// JavaScript for filtering by category and price

// Function to filter products by category and price
function applyFilters() {
    const selectedCategory = document.querySelector('.category-filter.active')?.getAttribute('data-category-id') || 'all';
    const selectedPriceRange = document.querySelector('.price-filter:checked')?.getAttribute('data-price-range') || 'all';
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        const categoryId = card.getAttribute('data-category-id');
        const productPrice = parseFloat(card.getAttribute('data-price'));

        let categoryMatch = (selectedCategory === 'all' || categoryId === selectedCategory);
        let priceMatch = false;

        if (selectedPriceRange !== 'all') {
            const [minPrice, maxPrice] = selectedPriceRange.split('-').map(Number);
            priceMatch = (productPrice >= minPrice && productPrice <= maxPrice);
        } else {
            priceMatch = true;
        }

        if (categoryMatch && priceMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Event listener for category filter
const categoryLinks = document.querySelectorAll('.category-filter');
categoryLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        categoryLinks.forEach(link => link.classList.remove('active'));
        link.classList.add('active');
        applyFilters();
    });
});

// Event listener for price filter
const priceFilters = document.querySelectorAll('.price-filter');
priceFilters.forEach(radio => {
    radio.addEventListener('change', () => {
        applyFilters();
    });
});

// Initialize filters on page load
applyFilters();