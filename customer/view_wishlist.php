<?php
include "component/header.php";

$userID = $_SESSION['user_id'];
?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <h1 class="text-3xl font-extrabold mb-8 text-gray-900">My Wishlist (<span class="wishlistCount">0</span>)</h1>

    <?php
    // Fetch the products from the wishlist
    $product_info = $db->fetch_product_on_wish($userID);

    // Check if the result contains rows
    if ($product_info->num_rows > 0) {
        // Fetch all the results as an associative array
        $products = $product_info->fetch_all(MYSQLI_ASSOC);

        // Iterate through the products
        foreach ($products as $product):
            $promo_rate_percentage = $product['promo_rate'] * 100;
            $wish_id  = $product['wish_id'];
            $prod_id = $product['prod_id'];
            $category_name = $product['category_name'];
            $discount_amount = $product['prod_currprice'] * $product['promo_rate'];
            $discounted_price = $product['prod_currprice'] - $discount_amount;
            $prod_name = $product['prod_name'];
    ?>

    <!-- Main Product Container -->
    <div class="relative max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">
    <!-- Close Button -->
    <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl" data-wish_id="<?=$wish_id?>">
        &times;
    </button>

    <div class="md:flex gap-8">
        <!-- Images Section -->
        <div class="md:w-1/2 space-y-4">
            <img src="../upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded-lg shadow-md object-cover">
        </div>

        <!-- Product Details Section -->
        <div class="md:w-1/2">
            <?php if ($product['prod_promo_id']): ?>
                <!-- Title and Price -->
                <div class="mb-4">
                    <h2 class="text-3xl font-semibold text-gray-900"><?= $product['prod_name'] ?></h2>
                    <p class="text-red-500 text-xl font-semibold">PHP <?= number_format($discounted_price, 2); ?></p>
                    <p class="text-gray-500 line-through">₱<?= $product['prod_currprice'] ?></p>
                    <p class="text-green-500 text-sm font-medium">-<?= $promo_rate_percentage ?>% Off</p>
                </div>

                <!-- Discount Tag -->
                <div class="bg-blue-100 text-blue-700 p-4 rounded-lg mb-4">
                    <span class="font-bold text-lg">BEST DEAL</span> <?=($product['promo_rate']*100)?>% off <br>
                    <span class="text-xs"><?= $product['promo_name'] ?> | No min. spend. Valid till <?= $product['promo_expiration'] ?></span>
                </div>
            <?php else: ?>
                <div class="mb-4">
                    <h2 class="text-3xl font-semibold text-gray-900"><?= $product['prod_name'] ?></h2>
                    <p class="text-red-500 text-xl font-semibold">PHP <?= number_format($product['prod_currprice'], 2); ?></p>
                </div>
            <?php endif; ?>

            <!-- Product Description -->
            <div class="mb-4">
                <h3 class="text-gray-700 font-semibold text-lg mb-2">Description</h3>
                <p class="text-gray-600"><?= $product['prod_description'] ?></p>
            </div>

            <?php 
            // Fetch product sizes if available
            $result = $db->getAllProductSize($prod_id);
            $prod_size = $result->fetch_all(MYSQLI_ASSOC);
            if (!empty($prod_size)): 
            ?>

            <div class="mb-4">
                <h3 class="text-gray-700 font-semibold text-lg mb-2">Size</h3>
                <div class="grid grid-cols-4 gap-2">
                    <?php foreach ($prod_size as $size): 
                        $size_name = $size['size_name']; 
                    ?>
                        <button class="size-btn py-2 px-4 bg-gray-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200" data-size="<?= $size_name ?>">
                            <?= $size_name ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('.size-btn').click(function() {
                        $('.size-btn').removeClass('bg-blue-600 text-white').addClass('bg-gray-500');
                        $(this).removeClass('bg-gray-500').addClass('bg-blue-600 text-white');
                    });
                });
            </script>

            <?php endif; ?>

            <!-- Cart and Wishlist Buttons -->
            <div class="flex justify-center gap-4 mt-6">
                <a href="view_product.php?product_id=<?=$prod_id?>&&category=<?=$category_name?>&&prod_name=<?=$prod_name?>">
                    <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none transition-colors duration-200">
                        View Product
                    </button>
                </a>
            </div>

        </div>
    </div>
</div>


    <?php endforeach; ?>

    <?php
    } else {
    ?>
    <!-- No products in wishlist -->
    <div class="flex flex-col items-center justify-center bg-gray-100 p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Wishlist is Empty</h2>
        <p class="text-gray-600 mb-6">Looks like you don't have any products in your wishlist yet. Browse our products and add your favorites!</p>
        <a href="index.php">
            <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none">Browse Products</button>
        </a>
    </div>
    <?php
    }
    ?>
</div>

<?php include "component/footer.php"; ?>
<script src="js/cart.js"></script>
<script src="js/setAddress.js"></script>
