<!--Header-->
<header class="d-flex justify-content-between align-items-center bg-light border-bottom">
    <div class="logo-container">
        <a href="{{ route('homepage') }}" class = "link_neviditelny" aria-label="Homepage">
            <img src="/images/logo.png" alt="Logo" class="logo">
        </a>    
        <i class="bi bi-list icon_click"></i>
    </div>
    <div class="icons d-flex gap-3">
        @auth
            @if (!Auth::user()->is_admin)
                <a href="{{ route('favorites.index') }}" aria-label="Favorites">
                    <i class="bi bi-heart icon_click"></i>
                </a>
            @endif
        @else
            <a href="{{ route('favorites.index') }}" aria-label="Favorites">
                <i class="bi bi-heart icon_click"></i>
            </a>
        @endauth

        @auth 
            @if (Auth::user()->is_admin)
                <a href="{{ route('admin_profile') }}" aria-label="Admin profile">
                    <i class="bi bi-person-gear icon_click"></i>
                </a>
            @else
                <a href="{{ route('profile') }}" aria-label="User profile">
                    <i class="bi bi-person icon_click"></i>
                </a>
            @endif
        @endauth
        @guest
            <a href="{{ route('login') }}" aria-label="Login">
                <i class="bi bi-person icon_click"></i>
            </a>
        @endguest

        @auth
            @if (!Auth::user()->is_admin)
                <a href="{{ route('shopping_cart1') }}" aria-label="Shopping cart">
                    <i class="bi bi-bag icon_click"></i>
                </a>
            @endif
        @else
            <a href="{{ route('shopping_cart1') }}" aria-label="Shopping cart">
                <i class="bi bi-bag icon_click"></i>
            </a>
        @endauth
    </div>
    <!-- overlay nazov zobraz len ak je definovaný section 'show-overlay' -->
    @if(!empty($showOverlay) && $showOverlay)
        <a href="{{ route('homepage') }}" class="overlay-link">
            <div class="overlay-text">Maui Surf</div>
        </a>
    @endif


    <!-- PRODUCT OVERVIEW -->
    <div id="product-overview" class="product-overview-container">
        <div class="product-overview">
            <ul>
                <li id="surfboards" class="category">SURFBOARDS</li>
                    <ul id="surfboards-subcategories" style="display: none;">
                        <a href="{{ route('products.byCategory', ['category' => 'Surfboards']) }}"><li>All</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Surfboards', 'subcategory' => 'Short Surfboards']) }}"><li>Short-boards</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Surfboards', 'subcategory' => 'Mid-length Surfboards']) }}"><li>Middle-boards</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Surfboards', 'subcategory' => 'Long Surfboards']) }}"><li>Long-boards</li></a>
                    </ul>
                <li id="equipment" class="category">EQUIPMENT</li>
                    <ul id="equipment-subcategories" style="display: none;">
                        <a href="{{ route('products.byCategory', ['category' => 'Equipment']) }}"><li>All</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Equipment', 'subcategory' => 'Neoprens']) }}"><li>Neopren</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Equipment', 'subcategory' => 'Fins']) }}"><li>Fins</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Equipment', 'subcategory' => 'Leashes']) }}"><li>Leashes</li></a>
                    </ul>
                <li id="accessories" class="category">ACCESSORIES</li>
                    <ul id="accessories-subcategories" style="display: none;">
                        <a href="{{ route('products.byCategory', ['category' => 'Accessories']) }}"><li>All</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Accessories', 'subcategory' => 'T-shirts'])  }}"><li>T-shirts</li></a>
                        <a href="{{ route('products.bySubcategory', ['category' => 'Accessories', 'subcategory' => 'Hats'])  }}"><li>Hats</li></a>
                    </ul>
                <a href="{{ route('favorites.index') }}"><li id="favourites" class="category thin">FAVOURITES</li></a>
                <a href="{{ route('profile') }}"><li id="profile" class="category thin">PROFILE</li></a>
                <a href="{{ route('shopping_cart1') }}"><li id="shopping_bag" class="category thin">SHOPPING BAG</li></a>
            </ul>
        </div>
    </div>
</header>