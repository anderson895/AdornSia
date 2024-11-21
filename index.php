<?php
include "header.php";
include('backend/class.php');

$db = new global_class();
?>
<div class="container mx-auto px-4 py-6">
    <!-- Hamburger Button -->
    <button 
        id="hamburger-btn" 
        class="lg:hidden p-2 bg-gray-800 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div class="flex">
        <!-- Sidebar Filters -->
        <aside 
            id="sidebar" 
            class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full lg:relative lg:translate-x-0 lg:w-1/4 lg:h-auto p-4 transition-transform duration-300 ease-in-out z-50"
        >
            <button 
                id="close-sidebar" 
                class="lg:hidden p-2 text-gray-700 hover:text-gray-900 focus:outline-none"
            >
            </button>
            <h2 class="font-semibold mb-4">Categories</h2>
            <ul id="category-list">
                <li>
                    <a href="#" class="block py-2 text-gray-700 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-300 category-filter" data-category-id="all">
                        All Categories
                    </a>
                </li>
                <?php 
                $categories = $db->fetch_all_categories(); 
                foreach ($categories as $category):
                    echo ' 
                        <li>
                            <a href="#" class="block py-2 text-gray-700 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-300 category-filter" data-category-id="'.$category['category_id'].'">
                            '.ucfirst($category['category_name']).' 
                            </a>
                        </li>';
                endforeach;
                ?>
            </ul>

            <h2 class="font-semibold mt-6 mb-4">Price</h2>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="price" class="mr-2 price-filter" data-price-range="0-1000">
                    PHP 0 - PHP 1000
                </label>
                <label class="flex items-center">
                    <input type="radio" name="price" class="mr-2 price-filter" data-price-range="1000-2000">
                    PHP 1000 - PHP 2000
                </label>
                <label class="flex items-center">
                    <input type="radio" name="price" class="mr-2 price-filter" data-price-range="2000-3000">
                    PHP 2000 - PHP 3000
                </label>
            </div>
        </aside>

        <!-- Product Grid -->
        <main class="w-full lg:w-3/4 p-4 ml-auto">
            <?php include "backend/end-points/product_list.php";?>
        </main>
    </div>
</div>

<script>
    // JavaScript to toggle the sidebar
    document.getElementById('hamburger-btn').addEventListener('click', function () {
        document.getElementById('sidebar').classList.remove('-translate-x-full');
    });

    document.getElementById('close-sidebar').addEventListener('click', function () {
        document.getElementById('sidebar').classList.add('-translate-x-full');
    });

    // Close sidebar on overlay click (optional)
    document.addEventListener('click', function (e) {
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger-btn');
        if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>


<?php include "footer.php"; ?>

<script src="javascript/filter_price_category.js"></script>
