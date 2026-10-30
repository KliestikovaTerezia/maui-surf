<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\OrderItem;

class OrderController extends Controller{
    // order validacie
    private function validateOrderData(Request $request){
        return $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'shipping' => 'required|string',
            'payment' => 'required|string',
            'town' => 'required|string',
            'street' => 'required|string',
            'houseNumber' => 'required|string',
            'region' => 'required|string',
            'postalCode' => 'required|string',
            'country' => 'required|string',
            'total' => 'required|numeric',
        ]);
    }

    // vytvorenie objednavky
    private function createOrder(array $data){
        $shippingPrice = $data['shipping'] === 'express' ? 6.99 : 3.99;

        return Order::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'shipping_method' => $data['shipping'],
            'payment_method' => $data['payment'],
            'shipping_price' => $shippingPrice,
            'town' => $data['town'],
            'street' => $data['street'],
            'house_number' => $data['houseNumber'],
            'region' => $data['region'],
            'postal_code' => $data['postalCode'],
            'country' => $data['country'],
            'total_price' => $data['total'],
        ]);
    }

    public function process(Request $request){ //Cash on Delivery
        try {
            $cartItems = [];
            if (Auth::check()) {
                $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
            } else {
                $sessionCartItems = session()->get('cart', []);
                $cartItems = [];
                
                foreach ($sessionCartItems as $item) {
                    if (!isset($item['product_id'])) continue;
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->quantity = $item['quantity'];
                        $product->size = $item['size'];
                        $cartItems[] = $product; // neprepisuje sa
                    }
                }
            }
            
            // validacia pouzivatela
            $data = $this->validateOrderData($request);

            //ak mame nejake udaje v session tak spojime s datami
            if (!empty($sessionData)) {
                $data = array_merge($data, $sessionData);
            }

            $order = $this->createOrder($data);
            // vlozenie produktov k objednavke
            foreach ($cartItems as $item) {
                if (Auth::check()) {
                    $product = $item->product;
                    $quantity = $item->quantity;
                    $size = $item->size;
                } else {
                    $product = Product::find($item->id); 
                    $quantity = $item->quantity;
                    $size = $item->size;
                }
                if ($product) {
                    OrderItem::create([
                        'order_id'     => $order->id,
                        'product_id'   => $product->id,
                        'product_name' => $product->name,
                        'quantity'     => $quantity,
                        'size'         => $size,
                        'unit_price'   => $product->price,
                    ]);
                    // Odpocitanie zasob
                    $product->stock = max(0, $product->stock - $quantity); 
                    $product->save();

                }
            }    
            
            // Clear the cart session
            $this->clearCart($cartItems);

            return response()->json([
                'success' => true,
                'redirect' => '/confirmation',
            ]);

        } catch (\Exception $e) {
            Log::error('Error while processing order: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error processing order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function processOrderSession(Request $request){ //ked s kartou kupujem, nie cod
        try {
            $cartItems = [];
            if (Auth::check()) {
                $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
            } else {
                $sessionCartItems = session()->get('cart', []);
                $cartItems = [];

                foreach ($sessionCartItems as $item) {
                    if (!isset($item['product_id'])) continue;
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->quantity = $item['quantity'];
                        $product->size = $item['size'];
                        $cartItems[] = $product; // už žiadne prepísanie
                    }
                }
            }
            // ziskanie dat zo session
            $data = session()->get('order', []);

            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No order data in session',
                ], 400);
            }

            // Create order from session data
            $order = $this->createOrder($data);
            
            //vlozenie produktov k objednavke
            foreach ($cartItems as $item) {
                if (Auth::check()) {
                    $product = $item->product;
                    $quantity = $item->quantity;
                    $size = $item->size;
                } else {
                    $product = Product::find($item->id); 
                    $quantity = $item->quantity;
                    $size = $item->size;
                }
                if ($product) {
                    OrderItem::create([
                        'order_id'     => $order->id,
                        'product_id'   => $product->id,
                        'product_name' => $product->name,
                        'quantity'     => $quantity,
                        'size'         => $size,
                        'unit_price'   => $product->price,
                    ]);
                    // Odpocitanie zasob
                    $product->stock = max(0, $product->stock - $quantity); 
                    $product->save();

                }
            }

            // zmazanie session po psracovani
            $this->clearCart($cartItems);

            return response()->json([
                'success' => true,
                'redirect' => '/confirmation',
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing order session: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error processing order session: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function confirmation(){
        return view('confirmation');
    }

    public function saveOrderToSession(Request $request){ //na zobrazenie total a shipping v step3
        try {
            // Validate order data
            $data = $this->validateOrderData($request);

            // Calculate shipping price based on shipping method
            $shippingPrice = $data['shipping'] === 'express' ? 6.99 : 3.99;
            $data['shipping_price'] = $shippingPrice;

            // Save data to session
            session()->put('order', $data);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error saving order to session: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error saving order to session: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function clearCart($cartItems){
        if (Auth::check()) {
            // vymazanie kosika z databazy
            foreach ($cartItems as $item) {
                $item->delete();
            }
        } else {
            // vymazanie kosika zo session
            session()->forget('cart');
        }
    }   
}