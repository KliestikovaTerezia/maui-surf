@extends('layouts.app')

@section('title', 'User Profile/Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/admin_profile.js') }}"></script>
@endpush

@section('content')
    <div class="store-name text-center overlay-text">
        <a href="{{ route('homepage') }}" aria-label="Homepage">
            Maui Surf
        </a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4 order-sm-2">
                <h2 class = "meno">ADMIN - maui surf</h2> 
                <button id = "add" class="admin_btn button_uprava farba">
                    ADD PRODUCT<i class="bi bi-plus-square"></i>
                </button>
                <form method="POST" action="{{ route('admin_logout') }}">   
                    @csrf                
                    <button class="admin_btn button_uprava">
                        Log out<i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>    
            </div>
    
            <!-- Produkty -->
            <div class="col-sm-8">
                <div class="zoznam">
                    <div class = "lupa">
                    <h3 >Products</h3>
                        <form method="GET" action="{{ url()->current() }}" class="search-bar">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder=" Search...">
                            <button type="submit" class="neviditelny-button"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                    <ul class="list-group">
                        <!-- Produkt  -->
                         
                        @foreach ($products as $product)
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny darker">
                                        @php
                                            $imageToShow = $product->mainImage->image_path ?? ($product->images->first()->image_path ?? null);
                                        @endphp
                                        @if ($imageToShow)
                                            <img src="{{ asset($imageToShow) }}" alt="{{ $product->name }}" class="product_order_image">
                                        @endif
                                    </a>
                                    <div class="d-flex order_info">
                                        <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny darker">
                                            <div>
                                                <p class="product_title">{{ $product->name }}</p>
                                                <p class="product_details">Category: <strong>{{ $product->category->name }}</strong></p>
                                                <p class="product_details">Subcategory: <strong>{{ $product->subcategory->name }}</strong></p>
                                                <p class="product_details">Price: <strong>${{ number_format($product->price, 2) }}</strong></p>
                                            </div>
                                        </a>    
                                        <div class="admin_button">
                                            <button class="delete-product" aria-label="Delete product"><i class="bi bi-trash3"></i></button>
                                            <button class="change-btn" aria-label="Edit product" 
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}" 
                                                data-subcategory="{{ $product->subcategory_id }}" 
                                                data-description="{{ $product->description }}"
                                                data-short_description="{{ $product->short_description }}"
                                                data-features="{{ $product->features }}"
                                                data-price="{{ $product->price }}"
                                                data-stock="{{ $product->stock}}"

                                                data-images='@json($product->images)'
                                                data-size='@json($product->size)'
                                                data-color='@json($product->color)' > 
                                                Edit <i class="bi bi-pencil-square"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>                    
                </div>
            </div>
        </div>
    </div> 


    <!-- ciselnik stranok -->
    <div class="strankovanie">
        <!-- sipka vlavo -->
        @if ($products->onFirstPage())
            <button class="strankovanie_sipka" aria-label="Pages left" disabled><i class="bi bi-chevron-left"></i></button>
        @else
            <a href="{{  request()->fullUrlWithQuery(['page' => $products->currentPage() - 1]) }}" class="strankovanie_sipka">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif
        <!-- cisla -->
        @for ($i = 1; $i <= $products->lastPage(); $i++)
            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="stranka {{ $products->currentPage() == $i ? 'active' : '' }}">
                {{ $i }}
            </a>
        @endfor
        <!-- sipka vpravo -->
        @if ($products->hasMorePages())
            <a href="{{ request()->fullUrlWithQuery(['page' => $products->currentPage() + 1])  }}" class="strankovanie_sipka"><i class="bi bi-chevron-right"></i></a>
        @else
            <button class="strankovanie_sipka" aria-label="Pages right" disabled><i class="bi bi-chevron-right"></i></button>
        @endif
    </div>

    <!-- EDIT OVERLAY -->
    <div class="change-product-overlay" id="editOverlay">
        <div class="overlay-content">
            <span class="close-btn" onclick="closeEditOverlay()">&times;</span>
            <h3>Edit Product</h3>
            <form id="productForm" action="{{ route('edit_product', 'product_id_placeholder') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" id="productName">
                </div>

                <select name="subcategory_id" class="form-select" id="size">
                    <option disabled selected>-- Select a Subcategory --</option>
                    @if(isset($product))
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" 
                                {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                
                <div class="mb-3">
                    <label for="shortDesc" class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_description" id="shortDesc" rows="3"></textarea>
                </div>
    
                <div class="mb-3">
                    <label for="description"  class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                </div>
    
                <div class="mb-3">
                    <label for="features" class="form-label">Features</label>
                    <textarea class="form-control" name="features" id="features" rows="4"></textarea>
                </div>
    
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" step="0.01" min="0" max="2000" class="form-control" id="price">
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input name="stock" type="number" step="1" class="form-control" id="stock">
                </div>
    
                <div class="mb-3" id="sizeedit">
                    <label for="size" class="form-label">Availible sizes</label>
                    <div>
                        <label><input type="checkbox" name="size[]" value="XS"/> XS</label>
                        <label><input type="checkbox" name="size[]" value="S"/> S</label>
                        <label><input type="checkbox" name="size[]" value="M"/> M</label>
                        <label><input type="checkbox" name="size[]" value="L"/> L </label>
                        <label><input type="checkbox" name="size[]" value="XL"/> XL </label>
                    </div>
                </div>

                <div class="mb-3" id="coloredit">
                    <label class="form-label">Select Color</label>
                        <div>
                            <label> <input type="checkbox" name="color[]" value="red"/> Red</label>
                            <label><input type="checkbox" name="color[]" value="green"/> Green </label>
                            <label><input type="checkbox" name="color[]" value="blue"/> Blue </label>
                            <label><input type="checkbox" name="color[]" value="black"/> Black </label>
                            <label><input type="checkbox" name="color[]" value="white"/> White </label>
                            <label><input type="checkbox" name="color[]" value="yellow"/> Yellow</label>
                            <label><input type="checkbox" name="color[]" value="other"/> Other</label>
                        </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Photos</label>
                    <div class="photo-preview" id="photoPreview">
                        @if(isset($product))
                            @foreach ($product->images as $image)
                                <div class="photo-item" data-id="{{ $image->id }}">
                                    <img src="{{ asset($image->image_path) }}" alt="Product Image">
                                    <button class="delete-photo" type="button" onclick="deletePhoto(this)" aria-label="Delete photo">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif    
                    </div>
                    <input type="file" class="form-control mt-2" name="images[]" id="newPhoto" accept="image/*" multiple>

                </div>
                <button type="submit" id='save-edit-changes' class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- ADD NEW -->
    <div class="change-product-overlay" id="addOverlay">
        <div class="overlay-content">
            <span class="close-btn" onclick="closeAddOverlay()">&times;</span>
            <h3>Add New Product</h3>
            <form id="addProductForm" method="POST" action="{{ route('add_product') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input name="name" type="text" class="form-control" id="productName" placeholder="Enter product name">
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label">Subcategory</label>
                    <select name="subcategory_id" class="form-select" id="size">
                        <option ></option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="shortDesc" class="form-label">Short Description</label>
                    <textarea name="short_description" class="form-control" id="shortDesc" rows="3" placeholder="Enter short description"></textarea>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Enter detailed description"></textarea>
                </div>

                <div class="mb-3">
                    <label for="features" class="form-label">Features</label>
                    <textarea name="features" class="form-control" id="features" rows="4" placeholder="Enter product features"></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input name="price" type="number" step="0.01" min="0" max="2000" class="form-control" id="price" placeholder="Enter product price">
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input name="stock" type="number" step="1" class="form-control" id="stock" placeholder="Enter number of pieces you have in warehouse">
                </div>

                <div class="mb-3" >
                    <label for="size" class="form-label">Availible sizes</label>
                    <div >
                        <label><input type="checkbox" name="size[]" value="XS"/> XS</label>
                        <label><input type="checkbox" name="size[]" value="S"/> S</label>
                        <label><input type="checkbox" name="size[]" value="M"/> M</label>
                        <label><input type="checkbox" name="size[]" value="L"/> L </label>
                        <label><input type="checkbox" name="size[]" value="XL"/> XL </label>
                    </div>
                    <div id="sizeError" class="invalid-feedback" style="display: none;">Please select at least one size.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Color</label>
                        <div>
                            <label> <input type="checkbox" name="color[]" value="red"/> Red</label>
                            <label><input type="checkbox" name="color[]" value="green"/> Green </label>
                            <label><input type="checkbox" name="color[]" value="blue"/> Blue </label>
                            <label><input type="checkbox" name="color[]" value="black"/> Black </label>
                            <label><input type="checkbox" name="color[]" value="white"/> White </label>
                            <label><input type="checkbox" name="color[]" value="yellow"/> Yellow</label>
                            <label><input type="checkbox" name="color[]" value="other"/> Other</label>
                        </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Photos</label>
                    <div class="photo-preview" id="addphotoPreview">
                    </div>
                    <input name="images[]" multiple type="file" class="form-control mt-2" id="addnewPhoto" accept="image/*">
                </div>
                <button type="submit" class="save-btn">Add Product</button>
            </form>
        </div>
    </div>

    <!-- DELETE ISTOTA -->
    <div class="change-product-overlay" id="deleteOverlay">
        <div class="overlay-delete">
            <h6 class="text-center">Are you sure? Do you want to delete this product from your e-shop?</h6>
            <div class="sure-buttons">
            <form id="confirm_delete" method="POST">
                @csrf
                @method('DELETE')
                <button class="delete-yes">YES</button>
            </form>

            <button class="delete-no" onclick="closeDeleteOverlay()">NO</button>
            </div>    
        </div>
    </div>        

@endsection