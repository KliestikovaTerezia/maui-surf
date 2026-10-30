// MAUI SCROLL - zastavi sa heading na headeri ---------------------------------------------------------------------------------
window.addEventListener("scroll", function () {
    let scrollPosition = window.scrollY;
    let link = document.querySelector(".overlay-link");

    let targetTop = 60; // kde zastavi
    let newTop = 110 - scrollPosition * 1.5; // posuva sa hore ked scrollneme

    // prestane sa hybat ked zastane na headeri
    if (newTop <= targetTop) {
        link.style.top = `${targetTop}%`;
    } else {
        link.style.top = `${newTop}%`;
    }
});

// PRODUCT OVERVIEW------------------------------------------------------------------------------------------------------------------------
const biListIcon = document.querySelector('.bi-list');
const productOverviewContainer = document.getElementById('product-overview');

if (biListIcon && productOverviewContainer) {
    biListIcon.addEventListener('click', function () {
        productOverviewContainer.classList.toggle('visible');
    });
} else {
    console.warn('Product overview elements (.bi-list or #product-overview) not found.');
}

function toggleSubcategories(categoryId, subcategoryId) {
    const category = document.getElementById(categoryId);
    const subcategories = document.getElementById(subcategoryId);

    if (category && subcategories) {
        category.addEventListener('click', function () {
            if (subcategories.style.display === 'none' || subcategories.style.display === '') {
                subcategories.style.display = 'block';
            } else {
                subcategories.style.display = 'none';
            }
        });
    } else {
        console.warn(`Subcategory toggle failed: #${categoryId} or #${subcategoryId} not found.`);
    }
}
toggleSubcategories('surfboards', 'surfboards-subcategories');
toggleSubcategories('equipment', 'equipment-subcategories');
toggleSubcategories('accessories', 'accessories-subcategories');


// FILTER PRODUCTS--------------------------------------------------------------------------------------------------------------------------
const filterButton = document.getElementById('filter_start'); 
const filterMenu = document.getElementById('filter-menu');
const closeButton = document.getElementById('close_filter');
const efekt = document.getElementById('efekt');

filterButton.addEventListener("click", function() {
    filterMenu.classList.add("visible");  
    efekt.style.display = "block"; 
});

closeButton.addEventListener("click", closeFilterMenu);
efekt.addEventListener("click", closeFilterMenu);

function closeFilterMenu() {
    filterMenu.classList.remove("visible");  
    efekt.style.display = "none"; 
}
// pohyblivy a interaktivny price slider
const minSlider = document.getElementById('slider-1');
const maxSlider = document.getElementById('slider-2');
const minPriceText = document.getElementById('min-price');
const maxPriceText = document.getElementById('max-price');

function updatePrices() {
    let minVal = parseInt(minSlider.value);
    let maxVal = parseInt(maxSlider.value);

    // Zabezpeč, že min nie je väčší ako max
    if (minVal > maxVal) {
        [minVal, maxVal] = [maxVal, minVal];
    }

    minPriceText.textContent = `$ ${minVal}`;
    maxPriceText.textContent = `$ ${maxVal}`;
}

if (minSlider && maxSlider && minPriceText && maxPriceText) {
    updatePrices();

    minSlider.addEventListener('input', updatePrices);
    maxSlider.addEventListener('input', updatePrices);
}

// LOG IN OVERLAY (pri favorites)
function showLoginOverlay() {
    document.getElementById('login-overlay').style.display = 'flex';
}

function closeOverlay() {
    document.getElementById('login-overlay').style.display = 'none';
}