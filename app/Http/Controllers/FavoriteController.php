<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller{
    //pridanie favorite produktu
    public function add(Product $product){
        Auth::user()->favorites()->syncWithoutDetaching($product->id);
        return back();
    }
    //odstranenie favorite produktu
    public function remove(Product $product){
        Auth::user()->favorites()->detach($product->id);
        return back();
    }
    //zobrazenie
    public function index(){
        $favorites = Auth::user()->favorites()->get();
        return view('favorites', compact('favorites'));
    }
}