<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;

class ProductController extends Controller{ 
    // sortovanie produktov
    private function applySorting(Request $request, $query){
        switch ($request->get('sort')) {
            case 'price_asc':
                return $query->orderBy('price', 'asc');
            case 'price_desc':
                return $query->orderBy('price', 'desc');
            case 'az':
                return $query->orderBy('name', 'asc');
            case 'za':
                return $query->orderBy('name', 'desc');
            default:
                return $query->orderBy('created_at', 'desc');
        }
    }

    //filtrovanie produktov
    private function applyFilter(Request $request, $query){
        // Subkategoria
        if ($request->has('subcategory')) {
            $query->whereIn('subcategory_id', $request->input('subcategory'));
        }
        // Farba
        if ($request->has('color')) {
            $query->whereIn('color', $request->input('color'));
        }
        // Velkost
        if ($request->has('size')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->input('size') as $size) {
                    $q->orWhere('size', 'like', "%$size%");
                }
            });
        }
        // Cena
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [
                $request->input('min_price'),
                $request->input('max_price')
            ]);
        } elseif ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        } elseif ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        return  $query;
    }

    public function byCategory(Request $request, $category){ //ked klikneme na kategoriu
        $categoryModel = Category::where('name', ucfirst($category))->firstOrFail(); //vyhlada v databaze podla mena co sme zaklikli (accessories)
        $query = Product::where('category_id', $categoryModel->id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%");
                //   ->orWhere('short_description', 'ILIKE', "%{$search}%");
            });
        }

        $currentCategory = $categoryModel->name;
        $query = $this->applyFilter($request, $query);
        $query = $this->applySorting($request, $query);
        $products = $query->paginate(12);
        $subcategories = Subcategory::where('category_id', $categoryModel->id)->get(); //vyberiem subkategorie iba tej jednej kategorie
        return view('products', compact('products', 'currentCategory', 'subcategories'));
    }

    public function bySubcategory(Request $request, $category, $subcategory){ //ked klikneme na subkategoriu
        $categoryModel = Category::where('name', ucfirst($category))->firstOrFail();
        $subcategoryModel = Subcategory::where('name', ucfirst($subcategory))
            ->where('category_id', $categoryModel->id)
            ->firstOrFail();
        $query = Product::where('subcategory_id', $subcategoryModel->id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%");
                //   ->orWhere('short_description', 'ILIKE', "%{$search}%");
            });
        }    
        $query = $this->applyFilter($request, $query);
        $query = $this->applySorting($request, $query);
        $products = $query->paginate(12);
        $currentCategory = $categoryModel->name;
        $subcategories = Subcategory::where('category_id', $categoryModel->id)->get();
        return view('products', compact('products', 'currentCategory', 'subcategories'));
    }

    public function index(Request $request){ //cez lupu v homepage
        $query = Product::query(); //vytvori query kde ziska vsetky produkty
        if ($request->filled('search')) { //kontrola obsahu
            $search = $request->input('search');
    
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%");                  // podla name
                //   ->orWhere('short_description', 'ILIKE', "%{$search}%"); // podla short_description
            });
        }
        $query = $this->applyFilter($request, $query);  //filtrovanie
        $query = $this->applySorting($request, $query); //sortnutie ak treba
        $products = $query->paginate(12);
        $categories = Category::all(); //vyberie vsetky kategorie
        $currentCategory = '';
        $subcategories = Subcategory::all();
        return view('products', compact('products', 'currentCategory', 'subcategories'));
    }

    public function homepage(){ //
        $surfboards = Product::with('mainImage')->whereHas('category', function ($query) {
            $query->where('name', 'Surfboards');
        })->limit(4)->get();       
        
        $equipment = Product::with('mainImage')->whereHas('category', function ($query) {
            $query->where('name', 'Equipment');
        })->limit(4)->get();
    
        $accessories = Product::with('mainImage')->whereHas('category', function ($query) {
            $query->where('name', 'Accessories');
        })->limit(4)->get();
    
        return view('homepage', compact('surfboards', 'equipment', 'accessories'));
    }
      

    public function show($id){ //ked kliknes nam tak ta premeruje na detail produktu
        $product = Product::findOrFail($id);
        $features = explode(', ', $product->features); // Rozdelí reťazec na pole podľa čiarky
    
        $images = json_decode($product->images); 
    
        // Ak obrázky nie sú k dispozícii alebo ich je menej než 3, pridáme náhradné obrázky
        while (count($images) < 3) {
            $images[] = 'images/detail_green.jpg'; 
        }

        $all_products = Product::all();
        return view('product_detail', compact('product', 'features', 'images', 'all_products'));
    }
    
    public function showProfile() 
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);
        return view('profile', compact('user', 'all_products'));
    }


}