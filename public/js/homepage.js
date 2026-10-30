document.addEventListener('DOMContentLoaded', function () {
  // SEARCH BAR ANIMACIA---------------------------------------------------------------------------------------------------------------------------------
  const searchBar = document.querySelector('.search-bar');
  const searchInput = document.querySelector('.search-bar input');
  const searchIcon = document.querySelector('.search-bar .bi-search');

  if (searchIcon && searchBar && searchInput) {
      searchIcon.addEventListener('click', function () {
          searchBar.classList.toggle('expanded');
          if (searchBar.classList.contains('expanded')) {
              searchInput.focus();
          }
      });
  } else {
      console.warn('Search elements (.bi-search, .search-bar, or .search-bar input) not found.');
  }

  // PRODUCT OVERVIEW ------------------------------------------------------------------------------------------------------------------------------------
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