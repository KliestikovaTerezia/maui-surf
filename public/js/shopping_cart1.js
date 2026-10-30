function isElementPresent(selector) {
    return document.querySelector(selector) !== null;
}

// PRODUCT OVERVIEW ------------------------------------------------------------------------------------------------------------------------------------
const biListIcon = document.querySelector('.bi-list');
const productOverviewContainer = document.getElementById('product-overview');

if (biListIcon && productOverviewContainer) {
    biListIcon.addEventListener('click', function () {
        productOverviewContainer.classList.toggle('visible');
    });
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
    }
}

toggleSubcategories('surfboards', 'surfboards-subcategories');
toggleSubcategories('equipment', 'equipment-subcategories');
toggleSubcategories('accessories', 'accessories-subcategories');

// SHIPPING FORM LOGIC ------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    if (!isElementPresent('#checkout-form') || !isElementPresent('#continue-button')) {
        return;
    }
    const form = document.getElementById('checkout-form');
    const continueButton = document.getElementById('continue-button');
    const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"]');
    const shippingRadios = form.querySelectorAll('input[type="radio"][name="shipping"]');
    const paymentRadios = form.querySelectorAll('input[type="radio"][name="payment"]');
    const countrySelect = form.querySelector('select[name="country"]');

    // odstran non-digits
    const phoneInput = form.querySelector('input[name="phone"]');
    phoneInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // kontrola ci vsetky fields maju spravne data types
    function updateButtonState() {
        let isFilled = true;

        inputs.forEach(input => {
            const value = input.value.trim();
            if (value === '') {
                isFilled = false;
            } else if (input.name === 'phone' || input.name === 'houseNumber' || input.name === 'postalCode') {
                if (!/^[0-9]+$/.test(value)) {
                    isFilled = false; // Must be numbers
                }
            } else if (input.name === 'email') {
                if (!value.includes('@') || !value.includes('.')) {
                    isFilled = false; // Basic email check
                }
            } else {
                if (!/[a-zA-Z]/.test(value)) {
                    isFilled = false; // Must contain at least one letter
                }
            }
        });

        // kontrola radio buttons, vzdy jeden musi byt selected 
        const shippingChecked = Array.from(shippingRadios).some(radio => radio.checked);
        if (!shippingChecked) {
            isFilled = false;
        }

        // kontrola payment radio buttons vzdy jeden musi byt selected
        const paymentChecked = Array.from(paymentRadios).some(radio => radio.checked);
        if (!paymentChecked) {
            isFilled = false;
        }

        // kontrola vyplnenia Country
        if (countrySelect.value === '') {
            isFilled = false;
        }

        continueButton.disabled = !isFilled;
        console.log('isFilled:', isFilled); 
    }

    //update button 
    form.addEventListener('input', updateButtonState);
    form.addEventListener('change', updateButtonState); 
});

// chces sa prihlasit overlay?
function showLoginOverlay() {
    const overlay = document.getElementById('login-overlay');
    overlay.style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {
    const signInNo = document.getElementById('sign-in-no');
    const overlay = document.getElementById('login-overlay');
    if (!signInNo) return;

    signInNo.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });
});

// SHIPPING COST TOTAL v step2 ------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const cartData = document.querySelector('#cart-data');
    if (!cartData) return;

    const shippingInputs = document.querySelectorAll('input[name="shipping"]');
    const shippingCostEl = document.querySelector('.shipping-cost');
    const totalEl = document.querySelector('.total');

    let baseTotal = parseFloat(cartData.dataset.total);

    function updateTotalWithShipping() {
        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        const shippingCost = parseFloat(selectedShipping.dataset.cost);

        shippingCostEl.innerHTML = `<span class="bold2">Shipping: </span>${shippingCost.toFixed(2)}$`;

        const totalWithShipping = baseTotal + shippingCost;
        totalEl.innerHTML = `<span class="bold2">Total: </span>${totalWithShipping.toFixed(2)}$`;

        // Presunuté sem:
        sessionStorage.setItem('finalTotal', totalWithShipping.toFixed(2));
        sessionStorage.setItem('shippingCost', shippingCost.toFixed(2));
    }

    shippingInputs.forEach(input => {
        input.addEventListener('change', updateTotalWithShipping);
    });

    updateTotalWithShipping();
});


// v step3 ukaz vypocitany total so shipping --------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    const shippingAmountEl = document.getElementById('shipping-amount');
    const totalAmountEl = document.getElementById('total-amount');

    if (!shippingAmountEl || !totalAmountEl) return;

    const shippingCost = sessionStorage.getItem('shippingCost');
    const finalTotal = sessionStorage.getItem('finalTotal');

    if (shippingCost && shippingAmountEl) {
        shippingAmountEl.textContent = `${shippingCost}$`;
    }

    if (finalTotal && totalAmountEl) {
        totalAmountEl.textContent = `${finalTotal}$`;
    }
});

// DOBIERKA ? ULOZENIE PRESMEROVANIE ------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    const continueBtn = document.getElementById('continue-button');

    if (!form || !continueBtn) {
        console.log("Nie sme na cart2 – chýba formulár alebo tlačidlo.");
        return;
    }

    continueBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const selectedPayment = document.querySelector('input[name="payment"]:checked');
        if (!selectedPayment) {
            alert('Prosím, zvoľte spôsob platby.');
            return;
        }

        const paymentValue = selectedPayment.value;
        const formData = new FormData(form);

        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        const shippingPrice = selectedShipping ? selectedShipping.dataset.cost : 0;
        formData.append('shipping_price', shippingPrice);

        const finalTotal = sessionStorage.getItem('finalTotal') || 0;
        formData.append('total', finalTotal);

        const csrf = document.querySelector('input[name="_token"]')?.value;
        if (!csrf) {
            console.error('CSRF token neexistuje!');
            return;
        }

        console.log('Odosielam fetch na /order/process...');

        // Skontrolovať, či je platba "Cash on Delivery"
        if (paymentValue === 'cod') {
            // Ak je "Cash on Delivery", odošleme objednávku a presmerujeme na potvrdenie
            fetch('/order', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                body: formData
            })
            .then(res => {
                console.log('Server response:', res);
                if (!res.ok) throw new Error('Chyba pri odoslaní objednávky');
                return res.json();
            })
            .then(data => {
                console.log('Fetch úspešný:', data);
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = '/confirmation'; // Presmerovanie na potvrdenie
                }
            })
            .catch(err => {
                console.error('Chyba pri fetch:', err);
                alert('Objednávku sa nepodarilo odoslať. Detail chyby: ' + err.message);
            });
        } else {
            // Ak nie je "Cash on Delivery", odošleme údaje na server a uložíme ich do session
            fetch('/save-order-session', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                body: formData
            })
            .then(res => {
                console.log('Server response:', res);
                if (!res.ok) throw new Error('Chyba pri ukladaní údajov do session');
                return res.json();
            })
            .then(data => {
                console.log('Údaje uložené do session:', data);
                // Presmerovanie na cart_step3
                window.location.href = '/cart_step3';
            })
            .catch(err => {
                console.error('Chyba pri ukladaní údajov do session:', err);
                alert('Objednávku sa nepodarilo uložiť do session. Detail chyby: ' + err.message);
            });
        }
    });
});


// RETRIEVE FROM SESSION - ked ideme cez kartu, treba preniest objednavku form ------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    const purchaseButton = document.getElementById('purchase-button');

    if (!form || !purchaseButton) {
        console.log("Nie sme na cart3 – chýba formulár alebo tlačidlo.");
        return;
    }

    purchaseButton.addEventListener('click', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const csrf = document.querySelector('input[name="_token"]')?.value;

        if (!csrf) {
            console.error('CSRF token chýba!');
            return;
        }

        const finalTotal = sessionStorage.getItem('finalTotal') || 0;
        formData.append('total', finalTotal);

        console.log('Odosielam objednávku na /ordersession...');

        //posli nech sa objednavka posle zo session do databazy
        fetch('/process-order-session', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log('Fetch úspešný:', data);
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.href = '/confirmation';
            }
        })
        .catch(err => {
            console.error('Chyba pri fetch:', err);
            alert('Objednávku sa nepodarilo odoslať. Detail chyby: ' + err.message);
        });
    });
});


// FORMAT KARTA ------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    if (!isElementPresent('#checkout-form') || !isElementPresent('#purchase-button')) {
        return;
    }

    const form = document.getElementById('checkout-form');
    const purchaseButton = document.getElementById('purchase-button');
    const inputs = form.querySelectorAll('input[type="text"]');
    const cardNumInput = form.querySelector('input[name="cardNum"]');
    const expDateInput = form.querySelector('input[name="expDate"]');
    const cardNameInput = form.querySelector('input[name="cardName"]');
    const cvcInput = form.querySelector('input[name="cvc"]');

    // Formatovanie cisla karty
    cardNumInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = value.match(/.{1,4}/g).join(' ');
            e.target.value = value.slice(0, 19);
        }
    });

    // Formatovanie MM/YY
    expDateInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            e.target.value = `${value.slice(0, 2)}/${value.slice(2, 4)}`;
        } else {
            e.target.value = value;
        }
    });

    // Validacia datumu na karte
    function isValidExpDate(dateStr) {
        if (!/^\d{2}\/\d{2}$/.test(dateStr)) return false;
    
        const [monthStr, yearStr] = dateStr.split('/');
        const month = parseInt(monthStr, 10);
        const year = parseInt('20' + yearStr, 10);
    
        if (isNaN(month) || isNaN(year) || month < 1 || month > 12) return false;
    
        const now = new Date();
        const currentMonth = now.getMonth() + 1; 
        const currentYear = now.getFullYear();
    
        // Ak je rok v buducnosti, OK. Ak je rovnaký, kontrolujeme mesiac.
        if (year > currentYear) return true;
        if (year === currentYear && month >= currentMonth) return true;
    
        return false;
    }
    
    
    // Validacia udajov z formulára
    function updateButtonState() {
        const cardNumValid = cardNumInput.value.trim().length === 19;
        const cardNameValid = /^\p{L}+(?: \p{L}+)+$/u.test(cardNameInput.value.trim());
        const expDateValid = isValidExpDate(expDateInput.value.trim());
        const cvcValid = /^\d{3,4}$/.test(cvcInput.value.trim());
    
        const allFilled = cardNumValid && cardNameValid && expDateValid && cvcValid;
    
        purchaseButton.disabled = !allFilled;
    }

    form.addEventListener('input', updateButtonState);
    form.addEventListener('change', updateButtonState);

    
});


// KONTROLA MAX STOCK v kosiku------------------------------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.auto-update-form');

    forms.forEach(form => {
        const quantityInput = form.querySelector('input[name="quantity"]');
        const max = parseInt(quantityInput.getAttribute('max'));

        quantityInput.addEventListener('change', function (e) {
            let value = parseInt(e.target.value);

            if (value > max) {
                alert(`There are no more than ${max} items of this product in our stock.`);
                e.target.value = max;
            } else if (value < 1) {
                e.target.value = 1;
            }
            form.submit();
        });
    });
});



