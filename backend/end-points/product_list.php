<h1 class="text-2xl font-semibold mb-6">All Products</h1>

<!-- Search Input -->
<input type="text" id="search" class="w-full p-2 mb-4 border rounded" placeholder="Search Products...">

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="product-grid">
    <?php 
    $fetch_all_product = $db->fetch_all_product();  // Fetch all products

    foreach ($fetch_all_product as $product):
        if($product['prod_promo_id']){
            $promo_rate_percentage = $product['promo_rate'] * 100; // Assuming promo_rate is a decimal (e.g., 0.20 for 20%)
            $discount_amount = $product['prod_currprice'] * $product['promo_rate']; // Calculate the discount amount
            $discounted_price = $product['prod_currprice'] - $discount_amount; 
        }else{
            $discounted_price=$product['prod_currprice'];
        }
    ?>
    
    <!-- Product Card -->
    <div class="bg-white p-4 rounded shadow-lg transition-transform transform hover:scale-105 hover:shadow-2xl product-card" data-category-id="<?=$product['prod_category_id']?>" data-price="<?=$product['prod_currprice']?>">
        <a href="login.php">

            <!-- Product Image -->
            <img src="upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded mb-4 transition-transform hover:scale-105">

            <!-- Product Name with class for searching -->
            <h2 class="font-semibold text-lg transition-colors hover:text-blue-500 product-name"><?=$product['prod_name']?></h2>

            <!-- Product Description -->
            <p class="text-gray-600 transition-colors hover:text-gray-800"><?= substr($product['prod_description'], 0, 20) . (strlen($product['prod_description']) > 20 ? '...' : '') ?></p>

            <?php if ($product['prod_promo_id']): ?>
                <!-- Price with discount -->
                <p class="text-lg font-bold text-red-600">PHP <?=number_format($discounted_price, 2);?></p>
                <p class="text-sm text-gray-500 line-through">PHP <?=$product['prod_currprice']?></p>
                <p class="text-sm text-green-600"><?=$promo_rate_percentage?>% off</p>
            <?php else: ?>
                <p class="text-lg font-bold text-red-600">PHP <?=number_format($product['prod_currprice'], 2);?></p>
            <?php endif; ?>
        </a>
    </div>

    <?php endforeach; ?>
</div>


<script>
    $(document).ready(function() {
    // Bind the keyup event on the search input field
    $('#search').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase(); // Get the value of the search field

        // Loop through the product cards and show/hide based on the search term
        $('#product-grid .product-card').each(function() {
            var productName = $(this).find('.product-name').text().toLowerCase(); // Get the product name text

            // If the product name contains the search term, show the product card
            if (productName.indexOf(searchTerm) !== -1) {
                $(this).show(); // Show matching product
            } else {
                $(this).hide(); // Hide non-matching product
            }
        });
    });
});

</script>