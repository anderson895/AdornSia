<?php
include "component/header.php";
include('backend/class.php');

$db = new global_class();
?>

<div class="container mx-auto p-8">
    <!-- Header -->
    <h1 class="text-2xl font-extrabold mb-8 text-gray-900">My Cart (<span class="cartCount">2</span>)</h1>

    <!-- Main Content -->
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Left Section -->
<div class="w-full lg:w-2/3 space-y-8">
    <!-- Delivery Address -->
    <div class="p-6 border border-gray-300 rounded-xl bg-white shadow-lg">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
            <span class="material-icons text-red-500 mr-2">location_on</span> Delivery Address
        </h2>
        <p class="text-sm text-gray-600 mt-2">Login/Register to add an address or view saved addresses.</p>
        <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Address</button>
    </div>

    <!-- Product List -->
    <div class="p-6 bg-white rounded-xl shadow-lg space-y-6">
       
    <?php 

$userId=$_SESSION['user_id'];

    $getCartlist = $db->getCartlist($userId);  // Fetch all products

   
    ?>
    <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <input type="checkbox" class="mr-2"> All (2/2 items)
        </h3>

        <?php 
         foreach ($getCartlist as $cart):
            $promo_rate_percentage = $cart['promo_rate'] * 100; // Assuming promo_rate is a decimal (e.g., 0.20 for 20%)
            $discount_amount = $cart['prod_currprice'] * $cart['promo_rate']; // Calculate the discount amount
            $discounted_price = $cart['prod_currprice'] - $discount_amount; 

            
        ?>
        <!-- Product Item -->
        <div class="flex items-center border-t border-gray-200 pt-6">
            <input type="checkbox" class="mr-4 text-red-500">
            <img src="../upload/<?=$cart['prod_image']?>" alt="Product Image" class="w-20 h-20 object-cover rounded-md shadow-lg mr-6">
            <div class="flex-grow">
                <h4 class="font-semibold text-gray-900"><?=$cart['prod_name']?></h4>
                <p class="text-sm text-gray-600"><?= substr($cart['prod_description'], 0, 50) ?></p>

                <p class="text-sm text-gray-600">Size: <?=$cart['cart_prod_size']?></p>

                <!-- Quantity Input with Buttons -->
                <div class="flex items-center space-x-2 mt-2">
                    <button class="togglerMinus w-8 h-8 bg-gray-200 text-gray-800 rounded-md flex items-center justify-center hover:bg-gray-300 focus:outline-none"
                    data-user_id='<?=$cart['cart_user_id']?>'
                    data-product_id='<?=$cart['cart_prod_id']?>'
                    data-cart_prod_size='<?=$cart['cart_prod_size']?>'
                    >
                        <span class="material-icons text-sm">remove</span>
                    </button>
                    <input type="number" value="<?=$cart['cart_Qty']?>" class="w-16 h-8 text-center border border-gray-300 rounded-md px-2 py-1 text-sm" placeholder="Qty: 1" min="1" />
                    <button class="togglerAdd w-8 h-8 bg-gray-200 text-gray-800 rounded-md flex items-center justify-center hover:bg-gray-300 focus:outline-none"
                    data-user_id='<?=$cart['cart_user_id']?>'
                    data-product_id='<?=$cart['cart_prod_id']?>'
                    data-cart_prod_size='<?=$cart['cart_prod_size']?>'
                    >
                        <span class="material-icons text-sm">add</span>
                    </button>
                </div>
            </div>
            <div class="text-right">

           

            <?php if ($cart['prod_promo_id']): ?>
                <p class="text-red-600 font-semibold">Php <?=number_format(($cart['prod_currprice']-($cart['prod_currprice']-$discounted_price))*$cart['cart_Qty'])?></p>
                <p class="text-xs line-through text-gray-400">Php <?=number_format($cart['prod_currprice']*$cart['cart_Qty'])?> - <?=($cart['promo_rate']*100)?>%</p>
                <?php else: ?>
                    <p class="text-red-600 font-semibold">Php <?=number_format($cart['prod_currprice']*$cart['cart_Qty'],2)?></p>
                    <?php endif; ?>
                
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>


        <!-- Right Section -->
        <div class="w-full lg:w-1/3 space-y-8">
            <!-- Order Summary -->
            <div class="p-9 bg-white rounded-xl shadow-lg space-y-6">
                <h3 class="text-lg font-semibold text-gray-900">Order Summary</h3>
                <div class="flex justify-between text-sm text-gray-700">
                    <p>Sub-total (2 items)</p>
                    <p>Php 3,139.00</p>
                </div>
                <div class="flex justify-between text-sm text-green-600">
                    <p>Total Saving</p>
                    <p>- Php 1,998.00</p>
                </div>
                <div class="border-t border-gray-200 mt-6 pt-4">
                    <div class="flex justify-between text-sm text-gray-700">
                        <p>Vat</p>
                        <p>Vat Computation</p>
                    </div>
                   
                </div>
                <div class="grandTotal border-t border-gray-200 mt-6 pt-4 flex justify-between text-lg font-bold text-gray-900">
                    <p>Total</p>
                    <p>Php 1,141.00</p>
                </div>
                <button class="w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-600 mt-6 focus:outline-none focus:ring-2 focus:ring-red-500">Checkout</button>
            </div>
        </div>
    </div>
</div>

<?php include "component/footer.php"; ?>
