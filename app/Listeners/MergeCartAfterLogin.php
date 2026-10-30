<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class MergeCartAfterLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $sessionCart = session()->get('cart', []);

        foreach ($sessionCart as $item) {
            $productId = $item['product_id'];
        
            if (!$productId || !is_numeric($productId)) continue; 
        
            $existing = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->where('size', $item['size'])
                ->first();
        
            if ($existing) {
                $existing->quantity += $item['quantity'];
                $existing->save();
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }
        

        session()->forget('cart');
    }
}


