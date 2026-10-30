@extends('layouts.app')

@section('title', 'Shopping cart')

<!-- napis maui surf -->
@php
    $showOverlay = true;
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/shopping_cart1.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/shopping_cart1.js') }}"></script>
@endpush

@section('content')
    <div class="cart-heading">
        <p>What's in my bag</p>
        <div class="steps">
            <p class="this-step"><i class="bi bi-1-circle"></i>.<span class="step">step</span></p>
            <p><i class="bi bi-2-circle"></i>.<span class="step">step</span></p>
            <p><i class="bi bi-3-circle"></i>.<span class="step">step</span></p>
        </div>
    </div>

    <div class="bag">
        <div class="products">

            @foreach ($cartItems as $item)
                @php
                    $product = $item instanceof \App\Models\Product ? $item : $item->product;
                    $productId = $product->id;
                    $quantity = $item->quantity;
                    $size = $item->size;
                    $price = $product->price;
                @endphp

                <div class="product">
                    <a href="{{ route('product_detail', ['id' => $productId]) }}">
                        @if ($product->mainImage)
                            <img src="{{ asset($product->mainImage->image_path) }}" alt="{{ $product->name }}" class="cart_product darker">
                        @elseif($product->images->isNotEmpty())
                            <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="cart_product darker">
                        @else
                            <img src="/images/logo.png" alt="No image" class="cart_product darker">
                        @endif
                    </a>
                    <div class="description">
                        <div class="name-remove">
                            <a href="{{ route('product_detail', ['id' => $productId]) }}">
                                <p class="bold name">{{ $product->name }}</p>
                            </a>
                            <div class="remove-btn">
                                <form method="POST" action="{{ route('removeFromCart', ['id' => $productId]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-close" aria-label="Close"></button>
                                </form>
                                <p>remove</p>
                            </div>
                        </div>
                        <div class="specifications">
                            <form method="POST" action="{{ route('updateCartItem', ['id' => $productId]) }}" class="auto-update-form">
                                @csrf
                                @method('PUT')

                                <div class="size_quantity">
                                    <div class="size_form">
                                        @php
                                            $sizes = array_map('trim', explode(',', $product->size));
                                        @endphp

                                        <select id="sizes" name="select_size" onchange="this.form.submit()">
                                            @foreach ($sizes as $sizeOption)
                                                <option value="{{ $sizeOption }}" {{ $size === $sizeOption ? 'selected' : '' }}>
                                                    {{ $sizeOption }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="number-picker">
                                        <input type="number" name="quantity" value="{{ $quantity }}" min="1" max="{{ $product->stock }}" onchange="this.form.submit()">
                                    </div>
                                </div>

                                <p class="price"><span class="bold">Price: </span>{{ $price }} $</p>
                            </form>
                        </div>


                    </div>
                </div>
            @endforeach

        </div>

        @php
            $isEmpty = false;
            if (auth()->check()) {
                $isEmpty = $cartItems->isEmpty();
            } else {
                $cart = session('cart', []);
                $isEmpty = empty($cart);
            }
        @endphp


        <div class="buttons"> <!--ak je prazdny kosik, disabled button-->
            <div class="final-info">
                <p class="total"><span class="bold2">Total: </span>{{ number_format($total, 2) }} $</p>
            </div>
            <a href="{{ route('products') }}"><button class="shop-button">Continue Shopping</button></a>
            <button class="checkout-button"
                @if($isEmpty) disabled @endif
                @auth
                    onclick="window.location.href='{{ route('shopping_cart2') }}'"
                @else
                    onclick="showLoginOverlay()"
                @endauth
            >
                Checkout
            </button>
        </div>
    </div>

    <!-- sign in overlay -->
    <div id="login-overlay" class="login-overlay">
        <div class="overlay-content">
            <p>Would you like to sign in?</p>
            <div class="overlay-buttons">
                <a href="{{ route('login') }}" class="overlay-btn">Yes</a>
                <a href="{{ route('shopping_cart2') }}" class="overlay-btn">No</a>
            </div>
        </div>
    </div>
@endsection
