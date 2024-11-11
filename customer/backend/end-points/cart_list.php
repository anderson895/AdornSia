<?php 
$userId = $_SESSION['user_id'];
$getCartlist = $db->getCartlist($userId); 
$totalItems = count($getCartlist);
$subTotal = 0;
$totalSavings = 0;
?>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Left Section: Cart Items -->
    <div class="flex-grow">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
            <input type="checkbox" id="check-all" class="mr-2"> All 
        </h3>

        <?php 
        foreach ($getCartlist as $cart):
            $promo_rate_percentage = $cart['promo_rate'] * 100;
            $discount_amount = $cart['prod_currprice'] * $cart['promo_rate']; 
            $discounted_price = $cart['prod_currprice'] - $discount_amount; 

            $subTotal += $cart['prod_currprice'] * $cart['cart_Qty'];
            if ($cart['prod_promo_id']) {
                $totalSavings += ($cart['prod_currprice'] - $discounted_price) * $cart['cart_Qty'];
            }
        ?>
        <!-- Product Item -->
        <div class="flex items-center border-t border-gray-200 pt-6">
            <input type="checkbox" class="product-checkbox mr-4 text-red-500" data-product-id="<?=$cart['cart_prod_id']?>" data-price="<?=$cart['prod_currprice']?>" data-qty="<?=$cart['cart_Qty']?>" data-discount="<?=$cart['promo_rate']?>" data-has-promo="<?=$cart['prod_promo_id']?>">
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
                    data-cart_prod_size='<?=$cart['cart_prod_size']?>'>
                        <span class="material-icons text-sm">remove</span>
                    </button>
                    <input readonly type="number" value="<?=$cart['cart_Qty']?>" class="w-16 h-8 text-center border border-gray-300 rounded-md px-2 py-1 text-sm" placeholder="Qty: 1" min="1" />
                    <button class="togglerAdd w-8 h-8 bg-gray-200 text-gray-800 rounded-md flex items-center justify-center hover:bg-gray-300 focus:outline-none"
                    data-user_id='<?=$cart['cart_user_id']?>'
                    data-product_id='<?=$cart['cart_prod_id']?>'
                    data-cart_prod_size='<?=$cart['cart_prod_size']?>'>
                        <span class="material-icons text-sm">add</span>
                    </button>
                </div>
            </div>
            <div class="text-right">
                <?php if ($cart['prod_promo_id']): ?>
                    <p class="text-red-600 font-semibold">Php <?=number_format(($cart['prod_currprice']-($cart['prod_currprice']-$discounted_price))*$cart['cart_Qty'])?></p>
                    <p class="text-xs line-through text-gray-400">Php <?=number_format($cart['prod_currprice']*$cart['cart_Qty'])?> - <?=($cart['promo_rate']*100)?>%</p>
                <?php else: ?>
                    <p class="text-red-600 font-semibold">Php <?=number_format($cart['prod_currprice']*$cart['cart_Qty'], 2)?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>


