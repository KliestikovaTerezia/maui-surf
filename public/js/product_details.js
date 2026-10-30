// MAUI SCROLL - zastavi sa heading na headeri ---------------------------------------------------------------------------------
window.addEventListener("scroll", function () {
    let scrollPosition = window.scrollY;
    let link = document.querySelector(".overlay-link"); 
    let header = document.querySelector("header");
    
    let targetTop = 60; // kde zastavi
    let newTop = 110 - scrollPosition * 1.5; // posuva sa hore ked scrollneme

    // prestane sa hybat ked zastane na headeri
    if (newTop <= targetTop) {
        link.style.top = `${targetTop}%`;
    } else {
        link.style.top = `${newTop}%`;
    }
});

// PRODUCT OVERVIEW ------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
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
});


// CAROUSEL ---------------------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    const carouselTrack = document.querySelector('.carousel_track');
    const carouselItems = carouselTrack.children;
    let currentIndex = 0;

    // Posun na predchádzajúci obrázok
    prevButton.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            // Ak sme na prvom obrázku, presunieme sa na posledný
            currentIndex = carouselItems.length - 1;
        }
        carouselTrack.style.transform = `translateX(-${currentIndex * 90}vw)`; // 90vw je sirka obrazka
    });

    // Posun na ďalší obrázok
    nextButton.addEventListener('click', function () {
        if (currentIndex < carouselItems.length - 1) {
            currentIndex++;
        } else {
            // Ak sme na poslednom obrázku, presunieme sa na prvý
            currentIndex = 0;
        }
        carouselTrack.style.transform = `translateX(-${currentIndex * 90}vw)`; 
    });
});


// PHOTO BIG OVERLAY ------------------------------------------------------------------------------------------------------------------
const carouselImages = document.querySelectorAll('.carousel_photo, .carousel_photo1, .carousel_photo2');
const imageOverlay = document.getElementById('imageOverlay');
const enlargedImage = document.getElementById('enlargedImage');

// click na fotku
carouselImages.forEach(image => {
    image.addEventListener('click', () => {
        enlargedImage.src = image.src;
        imageOverlay.classList.add('active');
    });
});

// zavri overlay ked kliknes mimo
imageOverlay.addEventListener('click', (e) => {
    if (e.target === imageOverlay) {
        imageOverlay.classList.remove('active');
    }
});

// REVIEWS click ---------------------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelector('.stars');
    const reviewBlock = document.querySelector('.dropdown-features .detail-block:nth-child(4)');

    stars.addEventListener('click', function () {
        // Scroll na zaciatok reviews
        reviewBlock.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Otvorenie dropdown
        const reviewsDropdown = document.getElementById('dropdown-toggle-4');
        reviewsDropdown.checked = true;
    });
});


// ADDED TO CART NOTIFICATION ---------------------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const flashEl = document.getElementById('flash-data');
    if (flashEl) {
        const successMessage = flashEl.dataset.success;
        if (successMessage) {
            showCartNotification(successMessage);
        }
    }
});

function showCartNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('cart-notification');
    notification.innerText = message;
    document.body.appendChild(notification);

    //animacia notifikacie spustenie
    requestAnimationFrame(() => {
        notification.classList.add('show');
    });

    //odstran po 4sekundach
    setTimeout(() => {
        notification.classList.remove('show');

        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 4000);
}

//---------------------------------------------------------------------------------------------------------------------------------------------------
function updateSize() { //update vybranej velkosti
    var size = document.getElementById('sizes').value;
    document.getElementById('size-input').value = size;
}

function updateQuantity() { //update vybraneho mnozstva
    var quantity = document.getElementById('quantity').value;
    document.getElementById('quantity-input').value = quantity;
}

// LOG IN OVERLAY (pri favorites) --------------------------------------------------------------------------------------------------------------------
function showLoginOverlay() {
    document.getElementById('login-overlay').style.display = 'flex';
}

function closeOverlay() {
    document.getElementById('login-overlay').style.display = 'none';
}

