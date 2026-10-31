@extends('layouts.app')

@section('title', 'Favorites')

<!-- pre maui surf nazov v headeri -->
@php
    $showOverlay = true;
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/favorites.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
    <div class="container my-5 favorites-heading">
        <h2 class="text-center mb-4">Your Favorite Products</h2>
    </div>

    <div class="container my-4">
        <div class="row  row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($favorites as $product)
            <div class="col">
                <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny" aria-label="Product details">
                    <div class="card darker">
                        @if ($product->mainImage)
                            <img src="{{ asset($product->mainImage->image_path) }}" alt="{{ $product->name }}">
                        @endif
                        <!-- <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny" aria-label="Show details">
                            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                        </a> -->
                        <div class="produkt-ikonky">
                            <form action="{{ route('favorites.remove', ['product' => $product->id]) }}" method="POST"> <!--form na odstranenie-->
                                @csrf
                                @method('DELETE')
                                <button class="button-ikonka" aria-label="Remove from favorites">
                                    <i class="bi bi-heart-fill"></i>
                                </button>
                            </form>


                            @php
                                $sizes = array_map('trim', explode(',', $product->size)); 
                                $defaultSize = count($sizes) > 0 ? $sizes[0] : null;
                                $inCart = false;
                                    if (auth()->check()) {
                                        $inCart = auth()->user()->cartItems->contains(function ($item) use ($product) {
                                            return $item->product_id == $product->id;
                                        });
                                    } else {
                                        $sessionCart = session()->get('cart', []);
                                        foreach ($sessionCart as $item) {
                                            if (isset($item['product_id']) && $item['product_id'] == $product->id) {
                                                $inCart = true;
                                                break;
                                            }
                                        }
                                    }
                            @endphp
                            @if ($inCart) <!-- odstranenie z kosika -->
                                <form method="POST" action="{{ route('removeFromCart', ['id' => $product->id]) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button-ikonka" aria-label="Remove from cart">
                                        <i class="bi bi-bag-check-fill"></i>
                                    </button>
                                </form>
                            @else <!-- pridanie do kosika -->
                                {{-- Formulár pre PRIDANIE --}}
                                <form method="POST" action="{{ route('addToCart', ['id' => $product->id]) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="select_size" value="{{ $defaultSize }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="button-ikonka" aria-label="Add to cart">
                                        <i class="bi bi-bag"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="text-center">
                            <h5 class="text_produkt">{{ $product->name }}</h5>
                            <p class="text_cena">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        </div>
    </div>
@endsection