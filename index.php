<?php
include "header.php";
include('backend/class.php');

$db = new global_class();
?>
<div class="container mx-auto px-4 py-6">
    <!-- Toggle Button for Sidebar (Mobile View) -->
    <button id="toggleSidebar" class="lg:hidden bg-blue-500 text-white px-4 py-2 rounded mb-4">
        Filters
    </button>

    <!-- Main Layout -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Filters -->
        <aside id="sidebar" class="hidden lg:block w-full lg:w-1/4 p-4 bg-white rounded shadow-lg">
            <h2 class="font-semibold mb-4">Categories</h2>
            <ul id="category-list">
                <li>
                    <a href="#" class="block py-2 text-gray-700 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-300 category-filter" data-category-id="all">
                        All Categories
                    </a>
                </li>
                <?php 
                // Fetch categories
                $categories = $db->fetch_all_categories();
                foreach ($categories as $category):
                    echo ' 
                        <li>
                            <a href="#" class="block py-2 text-gray-700 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-300 category-filter" data-category-id="'.$category['category_id'].'">
                            '.$category['category_name'].' 
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
        <main class="w-full lg:w-3/4 p-4 bg-white rounded shadow-lg">
            <?php include "backend/end-points/product_list.php";?>
        </main>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    // JavaScript for Toggling Sidebar
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden');
    });
</script>

<?php include "footer.php"; ?>

<script src="javascript/filter_price_category.js"></script>
