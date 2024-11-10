<?php
include "component/header.php";
include('../backend/class.php');

$db = new global_class();
?>

<div class="container mx-auto px-4 py-6 flex">

    <!-- Sidebar Filters -->
    <aside class="w-1/4 p-4 bg-white rounded shadow-lg">
        <h2 class="font-semibold mb-4">Categories</h2>
        <ul id="category-list">
            <li>
                <a href="#" class="block py-2 text-gray-700 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-300 category-filter" data-category-id="all">
                    All Categories
                </a>
            </li>
            <?php 
            // Fetch categories
            $categories = $db->fetch_all_categories(); // Assuming a method to get all categories
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
            <!-- Add more options as needed -->
        </div>
    </aside>

    <!-- Product Grid -->
    <main class="w-3/4 p-4">
        <h1 class="text-2xl font-semibold mb-6">All Products</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="product-grid">
            <?php 
            $fetch_all_product = $db->fetch_all_product();  // Fetch all products

            foreach ($fetch_all_product as $product):
                $promo_rate_percentage = $product['promo_rate'] * 100; // Assuming promo_rate is a decimal (e.g., 0.20 for 20%)
                $discount_amount = $product['prod_currprice'] * $product['promo_rate']; // Calculate the discount amount
                $discounted_price = $product['prod_currprice'] - $discount_amount; 
            ?>
            
            <!-- Product Card -->
            <div class="bg-white p-4 rounded shadow-lg product-card" data-category-id="<?=$product['prod_category_id']?>" data-price="<?=$product['prod_currprice']?>">
                <img src="../upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded mb-4">
                <h2 class="font-semibold text-lg"><?=$product['prod_name']?></h2>
                <p class="text-gray-600"><?=$product['prod_description']?></p>
                <?php if ($product['prod_promo_id']): ?>
                    <p class="text-lg font-bold text-red-600">PHP <?=number_format($discounted_price, 2);?></p>
                    <p class="text-sm text-gray-500 line-through">PHP <?=$product['prod_currprice']?></p>
                    <p class="text-sm text-green-600"><?=$promo_rate_percentage?> off</p>
                <?php else: ?>
                    <p class="text-lg font-bold text-gray-800">PHP <?=$product['prod_currprice']?></p>
                <?php endif; ?>
            </div>

            <?php endforeach; ?>
        </div>
    </main>
</div>

<?php include "component/footer.php"; ?>

<script src="javascript/filter_price_category.js"></script>
