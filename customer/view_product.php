<?php
include "component/header.php";
include('backend/class.php');

$db = new global_class();

$userID=$_SESSION['user_id'];
$product_id=$_GET['product_id'];
$category=$_GET['category'];
$product_info = $db->fetch_product_info($product_id); 
foreach ($product_info as $product):
    $promo_rate_percentage = $product['promo_rate'] * 100; 
    $discount_amount = $product['prod_currprice'] * $product['promo_rate'];
    $discounted_price = $product['prod_currprice'] - $discount_amount; 
endforeach;
?>

<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumbs -->
    <div class="text-gray-500 text-sm mb-4">
        <a href="#" class="hover:underline">Home</a> &gt;
        <a href="#" class="hover:underline"><?=$category?></a> &gt;
        <a href="#" class="hover:underline"><?=$product['prod_name']?></a>
    </div>

    <!-- Main Product Container -->
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <div class="md:flex gap-8">
            
            <!-- Images Section -->
            <div class="md:w-1/2 space-y-4">
                <img src="../upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded-lg">
              
            </div>

            <!-- Product Details Section -->
            <div class="md:w-1/2">
            <?php if ($product['prod_promo_id']): ?>
                <!-- Title and Price -->
                <div class="mb-4">
                    <h2 class="text-2xl font-semibold"><?=$product['prod_name']?></h2>
                    
                    <p class="text-red-500 text-xl font-semibold">PHP <?=number_format($discounted_price, 2);?></p>
                    <p class="text-gray-500 line-through">₱<?=$product['prod_currprice']?></p>
                    <p class="text-green-500 text-sm font-medium">-<?=$promo_rate_percentage?>% Off</p>
                </div>

                <!-- Discount Tag -->
                <div class="bg-blue-100 text-blue-700 p-2 rounded-lg mb-4">
                    <span class="font-bold">BEST DEAL</span> <?=($product['promo_rate']*100)?>% off <br>
                    <span class="text-xs"><?=$product['promo_name']?> | No min. spend. Valid till <?=$product['promo_expiration']?></span>
                </div>
            <?php else: ?>
                <div class="mb-4">
                    <h2 class="text-2xl font-semibold"><?=$product['prod_name']?></h2>
                    <p class="text-red-500 text-xl font-semibold">PHP <?=number_format($product['prod_currprice'], 2);?></p>
                </div>
            <?php endif; ?>
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold mb-2">Description</h3>
                    <div class="flex space-x-2">
                        <p><?=$product['prod_description']?></p>
                    </div>
                </div>
               <?php 
    $result = $db->getAllProductSize($product_id);
    $prod_size = $result->fetch_all(MYSQLI_ASSOC);
    if (!empty($prod_size)): 
?>

<div class="mb-4">
    <h3 class="text-gray-700 font-semibold mb-2">Size</h3>
    <div class="grid grid-cols-4 gap-2">
        <?php foreach ($prod_size as $size): 
            $size_name = $size['size_name']; 
        ?>
            <button class="size-btn py-2 px-4 bg-gray-500 text-white rounded-lg hover:bg-blue-600" data-size="<?= $size_name ?>">
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
                <div class="flex gap-4 mt-6">
                    <button 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition btnAddToCart"
                        data-product_id="<?=$product_id?>"
                        data-user_id="<?=$userID?>"
                    >
                        Add to Cart
                    </button>
                    <button class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-100 transition btnAddToCart">
                        Add to Wishlist
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>










<?php include "component/footer.php"; ?>
