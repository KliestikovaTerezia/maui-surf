@extends('layouts.app')

@section('title', 'User Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
<div class="store-name text-center overlay-text">
    <a href="{{ route('homepage') }}">
        Maui Surf
    </a>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-4 order-sm-2">               
            <h2>{{ $user->name }}</h2>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="odhlasit_btn">Log out</button>
            </form>

            <button class="edit_profile_btn" >
                <i class="fas fa-edit"></i>Edit Profile
            </button>
            <button class="edit_profile_btn">Change password</button> 

            <div class="card my_card">
                    <div class="card-body">
                        <h5 class="card-title">Profile details</h5>
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> {{ $user->email }}</li>
                            <li><strong>Phone:</strong> {{ $user->phone_number }}</li>
                            <li><strong>Country:</strong> {{ $user->country }}</li>
                        </ul>
                    </div>
            </div>
                
            <div class="profil_info">
                <img src="images/surf images videos/pc1.jpg" alt="Profile image" class="profile-img mb-3">
            </div>

        </div>

        <!-- Historia objednávok -->
        <div class="col-sm-8">
            <div class="">
                <h3 >Your orders</h3>
                <ul class="list-group">
                    @foreach ($orders as $order)
                        @foreach ($order->items as $item)
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    @php
                                        $product = \App\Models\Product::with(['mainImage', 'images'])->find($item->product_id);
                                    @endphp
                                    @if ($product && $product->mainImage)
                                        <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny darker">
                                            <img src="{{ asset($product->mainImage->image_path) }}" alt="{{ $product->name }}" class="product_order_image">
                                        </a>
                                    @elseif ($product && $product->images->isNotEmpty())
                                        <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny darker">
                                            <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="product_order_image">
                                        </a>
                                    @else 
                                        <img src="/images/sold_out.png" alt="Product is not available anymore" class="product_order_image">
                                    @endif

                                    <div>
                                        <p class="order_title">{{ $item->product_name }}</p>
                                        <p class="order_details">
                                            Size: <strong>{{ $item->size ?? 'N/A' }}</strong> | 
                                            Amount: <strong>{{ $item->quantity }} pc</strong>
                                        </p>
                                        <p class="order_details">
                                            Prize: <strong>${{ number_format($item->unit_price * $item->quantity, 2) }}</strong>
                                        </p>
                                    </div>
                                    <!-- <span class="badge 
                                        @if ($order->status == 'Delivered') bg-success 
                                        @elseif ($order->status == 'Cancelled') bg-danger 
                                        @else bg-warning 
                                        @endif">
                                        {{ $order->status }}
                                    </span> -->
                                </div>
                            </li>
                        @endforeach
                    @endforeach

                </ul>

                <ul class="list-group">
                </ul>
                
            </div>
        </div>
    </div>
</div>

<div class="motivation">
    <img src="images/surf images videos/pc5.jpg" alt="Motivation Picture" class="motivation_img">
    <div class="citat">"You cant't stop the waves but you can learn to surf"</div>
</div>
@endsection