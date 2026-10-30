<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\ProductImage;


class AdminController extends Controller{
    // Overí e-mail a heslo, prihlási admina
    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin_profile'); 
            } else { //nie si admin, odhlasime ho
                Auth::logout();
                return redirect()->route('admin_login')
                    ->withErrors(['email' => 'Unauthorized access into admin account.'], 'login')
                    ->withInput();
            }
        }else{
            return redirect()->route('admin_login')
                ->withErrors(['email' => 'Login failed, invalid email or password'], 'login')
                ->withInput();
        }
    }

    public function profile(){ //Zobrazuje admin profil (zoznam produktov)
        if (Auth::check() && Auth::user()->is_admin) {
            $admin = Auth::user();

            $search = request('search');
            $query = Product::with(['category', 'subcategory', 'mainImage']);

            if ($search) { // Môže filtrovať produkty podľa názvu (parametrom search)
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%");
                });
            }

            $products = $query->orderBy('created_at', 'desc')->paginate(10); //zobrazi vsetky produkty, strankovanie
            $subcategories = Subcategory::all(); //nacita vsetky subkategorie z databazy
            return view('admin_profile', compact('products', 'subcategories'));        //odovzda udaje 
        } else {
            return redirect()->route('homepage');
        }
    }

    public function add(Request $request){ //prida novy produkt
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|max:2000',
            'images' => 'required|array|min:2',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5021',
            'stock' => 'nullable|numeric',
            'size' => 'required|array|min:1',
            'color' => 'nullable|array',
        ]);
        
        // získa category_id zo subkategórie
        $subcategory = Subcategory::findOrFail($validated['subcategory_id']);
        $categoryID = $subcategory->category_id;

        $product = Product::create([
            'name' => $validated['name'],
            'subcategory_id' => $validated['subcategory_id'],
            'category_id' => $categoryID,
            'stock' => $validated['stock'] ?? 1000,
            'price' => $validated['price'],
            'size' => isset($validated['size']) ? implode(',', $validated['size']) : '',
            'color' => isset($validated['color']) ? implode(',', $validated['color']) : '',
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description'),
            'features' => $request->input('features'),
        ]);

        foreach ($request->file('images') as $index => $image) {
            $filename = $image->getClientOriginalName(); 
            $image->move(public_path('images/products'), $filename); // vlozenie obrazka do obrazkov
        
            $product->images()->create([
                'image_path' => 'images/products/' . $filename, 
                'is_main' => $index === 0
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function delete(Product $product)    {
        //zmazanie obrazkov pre produkt v databaze
        foreach ($product->images as $image) {
            $image->delete(); 
        }
        $product->delete(); //zmazane produktu z databazy
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }


    public function edit(Request $request, Product $product){
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5021',
            'stock' => 'nullable|numeric',
            'size' => 'required|array|min:1',
            'color' => 'nullable|array',
        ]);

        //meno produktu updatujem len ak nebolo vymazane
        if ($request->has('name') && !empty($validated['name'])) {$product->name = $validated['name'];}
        $product->subcategory_id = $validated['subcategory_id'];
        $subcategory = Subcategory::findOrFail($validated['subcategory_id']);
        $product->category_id = $subcategory->category_id;
        //cena sa updatuje len ak bola v spravnom rozpati, inka zostava nezmenena
        if (isset($validated['price']) && $validated['price'] >= 0 && $validated['price'] <= 2000) {
            $product->price = $validated['price'];
        }
        $product->stock = $validated['stock'] ?? $product->stock;   //ak neni nastaveny, zostava na povodnej hodnote
        $product->short_description = $request->input('short_description'); 
        if (isset($validated['description']) && !empty($validated['description'])) { //ak to nahodou vymazal, neupdatne sa to, required 
            $product->description = $validated['description'];
        }
        $product->features = $request->input('features');
        $product->size =  isset($validated['size']) ? implode(',', $validated['size']) : '';
        $product->color =  isset($validated['color']) ? implode(',', $validated['color']) : '';
        
        $product->save();
    
        // obrazok
        if ($request->hasFile('images')) { 
            foreach ($request->file('images') as $index => $image) {
                $filename = $image->getClientOriginalName(); //ziskam jeho origos meno
                $image->move(public_path('images/products'), $filename); // uloženie do /public/images/products
        
                $product->images()->create([
                    'image_path' => 'images/products/' . $filename,
                    'is_main' => false, // alebo nejako urči hlavný obrázok
                ]);
            }
        }
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id === $product->id) { //vymaze ho len ak je aj v databaze
                    $image->delete();
                }
            }
        }        
        return redirect()->back()->with('success', 'Product updated successfully!');
    }



    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage');
    }
}