@extends('layouts.app')

@section('title', 'Maui Surf')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/homepage.js') }}"></script>
@endpush

@section('content')
    <!--Banner-->
    <div class="banner-container">
        <video src="images/surf images videos/surfisti_na_vlne.mp4" class="img-fluid w-100" autoplay loop muted playsinline></video>
        <div class="overlay-text">Maui Surf</div>
        <div class="banner-text">
            <div class="text_on_banner">The waves are calling - ride them in style! Find the best surf gear here.</div>
        </div>
        
        <form method="GET" action="{{ route('products') }}" class="search-bar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder=" Search...">
            <button type="submit" class="neviditelny-button"><i class="bi bi-search"></i></button>
        </form>

    </div>

    <div class="nav">
        <a href="{{ route('products.byCategory', ['category' => 'Surfboards']) }}"><h2>SURFBOARDS</h2></a>
        <a href="{{ route('products.byCategory', ['category' => 'Equipment']) }}"><h2>EQUIPMENT</h2></a>
        <a href="{{ route('products.byCategory', ['category' => 'Accessories']) }}"><h2>ACCESSORIES</h2></a>
    </div>
    
    <!-- Products -->
    <div class="products">
        <!-- Surfboards Section -->
        <div class="product_left">
            @if ($surfboards->isNotEmpty())
                @php
                    $firstProduct = $surfboards[0];
                    $firstImage = $firstProduct->mainImage ?? $firstProduct->images->first();
                @endphp
                <a href="{{ route('product_detail', ['id' => $firstProduct->id]) }}" class="link_neviditelny">
                    @if ($firstImage)
                        <img src="{{ asset($firstImage->image_path) }}" alt="{{ $firstProduct->name }}" class="surfboard_picture darker">
                    @endif
                </a>
            @endif

            <div class="surfboard_products">
                <div class="three_products">
                    @foreach ($surfboards->skip(1) as $product)
                        @php
                            $image = $product->mainImage ?? $product->images->first();
                        @endphp
                        <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny">
                            @if ($image)
                                <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="surfboard_product darker">
                            @endif
                        </a>
                    @endforeach

                    @if ($surfboards->count() < 4)
                        @foreach ($surfboards->take(4 - $surfboards->count()) as $product)
                            @php
                                $image = $product->mainImage ?? $product->images->first();
                            @endphp
                            <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny">
                                @if ($image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="surfboard_product darker">
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <div class="pretty-box">
                        <p class="pretty-text">Surfboards</p>
                    </div>
                </div>

                <div class="surfboard_button">
                    <a href="{{ route('products.byCategory', ['category' => 'Surfboards']) }}">
                        <button class="custom-btn">More</button>
                    </a>
                </div>
            </div>
        </div>


        <!-- Equipment Section -->
        <div class="product_right">
            @if ($equipment->isNotEmpty())
                @php
                    $firstProduct = $equipment[0];
                    $firstImage = $firstProduct->mainImage ?? $firstProduct->images->first();
                @endphp
                <a href="{{ route('product_detail', ['id' => $firstProduct->id]) }}" class="link_neviditelny">
                    @if ($firstImage)
                        <img src="{{ asset($firstImage->image_path) }}" alt="{{ $firstProduct->name }}" class="equipment_picture darker">
                    @endif
                </a>
            @endif

            <div class="equipment_products">
                <div class="three_products">
                    @foreach ($equipment->skip(1) as $product)
                        @php
                            $image = $product->mainImage ?? $product->images->first();
                        @endphp
                        <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny">
                            @if ($image)
                                <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="equipment_product darker">
                            @endif
                        </a>
                    @endforeach

                    @if ($equipment->count() < 4)
                        @foreach ($equipment->take(4 - $equipment->count()) as $product)
                            @php
                                $image = $product->mainImage ?? $product->images->first();
                            @endphp
                            <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny">
                                @if ($image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="equipment_product darker">
                                @endif
                            </a>
                        @endforeach
                    @endif
                </div>

                <div class="surfboard_button">
                    <a href="{{ route('products.byCategory', ['category' => 'Equipment']) }}">
                        <button class="equipment-custom-btn">More</button>
                    </a>
                    <div class="pretty-box-reverse">
                        <p class="pretty-text">Equipment</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accessories Section -->
        <div class="product_left">
            @if ($accessories->isNotEmpty())
                @php
                    $firstProduct = $accessories[0];
                    $firstImage = $firstProduct->mainImage ?? $firstProduct->images->first();
                @endphp
                <a href="{{ route('product_detail', ['id' => $firstProduct->id]) }}" class="link_neviditelny">
                    @if ($firstImage)
                        <img src="{{ asset($firstImage->image_path) }}" alt="{{ $firstProduct->name }}" class="surfboard_picture darker">
                    @endif
                </a>
            @endif

            <div class="surfboard_products">
                <div class="three_products">
                    @foreach ($accessories->skip(1) as $product)
                        @php
                            $image = $product->mainImage ?? $product->images->first();
                        @endphp
                        <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny">
                            @if ($image)
                                <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="surfboard_product darker">
                            @endif
                        </a>
                    @endforeach

                    @if ($accessories->count() < 4)
                        @foreach ($accessories->take(4 - $accessories->count()) as $product)
                            @php
                                $image = $product->mainImage ?? $product->images->first();
                            @endphp
                            <a href="{{ route('product_detail', ['id' => $product->id]) }}" class="link_neviditelny">
                                @if ($image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" class="surfboard_product darker">
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <div class="pretty-box">
                        <p class="pretty-text">Accessories</p>
                    </div>
                </div>

                <div class="surfboard_button">
                    <a href="{{ route('products.byCategory', ['category' => 'Accessories']) }}">
                        <button class="custom-btn">More</button>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection