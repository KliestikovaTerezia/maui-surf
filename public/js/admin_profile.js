//EDIT PRODUCT - PREDVYPLNENIE UDAJOV
document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.querySelectorAll('.change-btn'); 
    const myWindow = document.getElementById('editOverlay')

    editButton.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const form = document.getElementById('productForm');
            form.action = `/admin/products/${productId}`;
            const images = JSON.parse(this.dataset.images);
            const photoPreview = document.getElementById('photoPreview');
            photoPreview.innerHTML = '';

            images.forEach(image => {
                const photoDiv = document.createElement('div');
                photoDiv.className = 'photo-item';
                photoDiv.dataset.id = image.id;
                photoDiv.innerHTML = `
                    <img src="/${image.image_path}" alt="Product Image">
                    <button class="delete-photo" type="button" onclick="deletePhoto(this)">
                        <i class="bi bi-x-circle"></i>
                    </button>
                `;
                photoPreview.appendChild(photoDiv);
            });
            validateImageCount();

            const sizes = this.dataset.size ? this.dataset.size.split(',').map(s => s.trim().replace(/^"|"$/g, '')) : [];
            const colors = this.dataset.color ? this.dataset.color.split(',').map(c => c.trim().replace(/^"|"$/g, '')) : [];
            

            //vynulovanie checkboxov
            document.querySelectorAll('#sizeedit input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.querySelectorAll('#coloredit input[type="checkbox"]').forEach(cb => cb.checked = false);

            //zaznacenie velkosti
            sizes.forEach(size => {
                const checkbox = document.querySelector(`#sizeedit input[type="checkbox"][value="${size}"]`);
                if (checkbox) checkbox.checked = true;
            });

            // zaznacenie farby
            colors.forEach(color => {
                const checkbox = document.querySelector(`#coloredit input[type="checkbox"][value="${color}"]`);
                if (checkbox) checkbox.checked = true;
            });

            //vyplnenie formulara
            document.getElementById('productName').value = this.dataset.name;
            document.getElementById('size').value = this.dataset.subcategory;
            document.getElementById('shortDesc').value = this.dataset.short_description;
            document.getElementById('description').value = this.dataset.description;
            document.getElementById('features').value = this.dataset.features;
            document.getElementById('price').value = this.dataset.price;
            document.getElementById('stock').value = this.dataset.stock;

            form.action = form.action.replace('product_id_placeholder', this.dataset.id);

            myWindow.style.display = 'block';
        });
    });
});


function validateImageCount() {
    const totalImages = uploadedFiles.length + document.querySelectorAll('.photo-item[data-id]').length;
    const saveButton = document.getElementById('save-edit-changes');
    const imageInput = document.getElementById('newPhoto');
    const feedbackContainer = imageInput.closest('.mb-3');
    let valid = true;
    //kontrola, ci ma produkt 2 obrazky
    if (totalImages < 2) {
        imageInput.classList.add('is-invalid');
        saveButton.disabled = true;
        let feedback = feedbackContainer.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = 'Product requieres at least 2 images';
            feedbackContainer.appendChild(feedback);
        }
    } else {
        saveButton.disabled = false;
        imageInput.classList.remove('is-invalid');
        const feedback = feedbackContainer.querySelector('.invalid-feedback');
        if (feedback) feedback.remove();
    }
}

let uploadedFiles = [];
const fileInput = document.getElementById('newPhoto');
const photoPreview = document.getElementById('photoPreview');

fileInput.addEventListener('change', function (e) { //pri kazdej zmene obrazkov
    const files = Array.from(e.target.files);
    files.forEach(file => {
        uploadedFiles.push(file);

        const reader = new FileReader();
        reader.onload = function (e) {
            const photoDiv = document.createElement('div');
            photoDiv.className = 'photo-item';
            photoDiv.dataset.filename = file.name;
            photoDiv.innerHTML = `
                <img src="${e.target.result}" alt="New photo">
                <button type="button" class="delete-photo" onclick="deletePhoto(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
            `;
            photoPreview.appendChild(photoDiv);
        };
        reader.readAsDataURL(file);
    });
    updateFileInput();
    validateImageCount();

});

function deletePhoto(button) { //robime s deleted polom 
    const photoDiv = button.parentElement;
    const filename = photoDiv.dataset.filename;
    const imageId = photoDiv.dataset.id;
    if (imageId) { //obrazok ktory uz bol v databaze a bude sa vymazavat z databazy
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'deleted_images[]'; //pridame ho do pola deleted images
        input.value = imageId;
        document.getElementById('productForm').appendChild(input);
    }
    if (filename) { 
        uploadedFiles = uploadedFiles.filter(f => f.name !== filename);
        updateFileInput(); //updatneme input, nezobrazi sa nam uz
    }

    photoDiv.remove();
    validateImageCount();

}

function updateFileInput() {
    const dataTransfer = new DataTransfer();
    uploadedFiles.forEach(file => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;
}

const myWindow = document.getElementById('editOverlay')
function closeEditOverlay() {
    myWindow.style.display = 'none';
}
document.getElementById('productForm').addEventListener('submit', function() {
    closeEditOverlay();
});
myWindow.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditOverlay();
    }
});







// NOVY PRODUKT --zobrazenie formulara
const addButton = document.getElementById('add');
const newWindow = document.getElementById('addOverlay');

addButton.addEventListener('click', function() {
    newWindow.style.display = 'block';
});

function closeAddOverlay() {
    newWindow.style.display = 'none';
}

document.getElementById('addProductForm').addEventListener('submit', function() {
    closeAddOverlay();
});

newWindow.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddOverlay();
    }
});

// kontrola povinnych udajov a sprava obrazkov vo formulari add product
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addProductForm');
    const nameInput = form.querySelector('input[name="name"]');
    const subcategoryInput = form.querySelector('select[name="subcategory_id"]');
    const descriptionInput = form.querySelector('textarea[name="description"]');
    const priceInput = form.querySelector('input[name="price"]');
    const sizeInput = form.querySelectorAll('input[name="size[]"]');
    const imageInput = form.querySelector('input[name="images[]"]');
    const submitButton = form.querySelector('button[type="submit"]');
    const previewContainer = document.getElementById('addphotoPreview');
    let selectedFiles = [];

    const showError = (input, message) => {
        input.classList.add('is-invalid');
        if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
            const error = document.createElement('div');
            error.className = 'invalid-feedback';
            error.textContent = message;
            input.parentNode.appendChild(error);
        }
    };

    const clearError = (input) => { 
        input.classList.remove('is-invalid');
        const error = input.parentNode.querySelector('.invalid-feedback');
        if (error) error.remove();
    };

    function validateForm() {
        let valid = true;

        // name
        if (nameInput.value.trim() === '') {
            showError(nameInput, 'Product name is required.');
            valid = false;
        } else {
            clearError(nameInput);
        }

        // subcategory
        if (!subcategoryInput.value) {
            showError(subcategoryInput, 'Please select a subcategory.');
            valid = false;
        } else {
            clearError(subcategoryInput);
        }

        // description
        if (descriptionInput.value.trim() === '') {
            showError(descriptionInput, 'Description is required.');
            valid = false;
        } else {
            clearError(descriptionInput);
        }

        // size
        const isChecked = Array.from(sizeInput).some(cb => cb.checked);
        const sizeError = document.getElementById('sizeError'); //zoberie sa html text errorovy id = sizeError
        if (!isChecked) {
            sizeError.style.display = 'block';
            valid = false;
        } else {
            sizeError.style.display = 'none';
        }
        sizeInput.forEach(cb => {
            cb.addEventListener('change', validateForm);
        });
                
        // price
        const price = parseFloat(priceInput.value);
        if (isNaN(price) || price <= 0 || price > 2000) {
            showError(priceInput, 'Price must be a number between 0 and 2000.');
            valid = false;
        } else {
            clearError(priceInput);
        }

        // images
        if (selectedFiles.length < 2) {
            imageInput.classList.add('is-invalid');
            const existingFeedback = imageInput.closest('.mb-3').querySelector('.invalid-feedback');
            if (!existingFeedback) {
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'Please upload at least 2 images.';
                imageInput.closest('.mb-3').appendChild(feedback);
            }
            valid = false;
        } else {
            imageInput.classList.remove('is-invalid');
            const existingFeedback = imageInput.closest('.mb-3').querySelector('.invalid-feedback');
            if (existingFeedback) existingFeedback.remove();
        }

        // submit button funkcnost
        submitButton.disabled = !valid;
    }

    // zobrazenie pridanych fotiek vo formulari
    function updatePreview() {
        previewContainer.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const photoDiv = document.createElement('div');
                photoDiv.className = 'photo-item';
                photoDiv.innerHTML = `
                    <img src="${event.target.result}" alt="Preview">
                    <button type="button" class="delete-photo" data-index="${index}">
                        <i class="bi bi-x-circle"></i>
                    </button>
                `;
                previewContainer.appendChild(photoDiv);
            };
            reader.readAsDataURL(file);
        });
        validateForm(); // validacia ci uz mam nahrate 2 fotky
    }

    // pridanie fotky
    imageInput.addEventListener('change', function (e) {
        const newFiles = Array.from(e.target.files);
        selectedFiles = selectedFiles.concat(newFiles);
        updatePreview();
    });

    // vymazanie fotky
    previewContainer.addEventListener('click', function (e) {
        if (e.target.closest('.delete-photo')) {
            const index = parseInt(e.target.closest('.delete-photo').dataset.index);
            selectedFiles.splice(index, 1);
            updatePreview();
        }
    });

    form.addEventListener('submit', function (e) {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    });

    [nameInput, descriptionInput, priceInput, imageInput, subcategoryInput].forEach(input => {
        input.addEventListener('input', validateForm);
        input.addEventListener('change', validateForm);
    });

    validateForm();
});


// DELETE ISTOTA
const trashButton = document.querySelectorAll('.delete-product'); 
const deleteWindow = document.getElementById('deleteOverlay');

trashButton.forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.closest('li').querySelector('.change-btn').dataset.id;
        const deleteForm = document.getElementById('confirm_delete');
        deleteForm.action = `/admin/products/${productId}`;
        deleteWindow.style.display = 'block';
    });
});


function closeDeleteOverlay() {
    deleteWindow.style.display = 'none';
}
deleteWindow.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteOverlay();
    }
});

function deleteProduct(){
    closeDeleteOverlay();
}


// PRODUCT OVERVIEW
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