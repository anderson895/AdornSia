<?php 
$db = new global_class();
$orderId = $_GET['orderId'];
$fetch_item_orders = $db->fetch_item_orders($orderId);

if ($fetch_item_orders): 
    // Format the order date
    $orderDate = new DateTime($fetch_item_orders[0]['order_date']);
    $formattedDate = $orderDate->format('F j, Y g:i A');  // MONTH DAY YEAR Time format
?>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <!-- Order Date Section -->
        <div class="bg-blue-100 p-6 rounded-lg mb-6 shadow-md">
            <p class="font-semibold text-xl text-blue-800">Order Date: <span class="text-gray-600"><?= $formattedDate; ?></span></p>
        </div>

        <!-- Order Summary Section -->
        <div class="bg-gray-50 p-6 rounded-lg mt-6 shadow-md">
            <p class="font-semibold text-lg text-gray-800">
                Subtotal: <span class="text-gray-500"><?= $fetch_item_orders[0]['subtotal']; ?></span>
            </p>
            <p class="font-semibold text-lg text-gray-800">
                VAT: <span class="text-gray-500"><?= $fetch_item_orders[0]['vat']; ?></span>
            </p>
            <p class="font-semibold text-lg text-gray-800">
                Total: <span class="text-gray-500"><?= $fetch_item_orders[0]['total']; ?></span>
            </p>
        </div>

        <!-- Delivery Address Section -->
        <div class="bg-gray-50 p-6 rounded-lg mt-6 shadow-md mb-6">
            <p class="font-semibold text-lg text-gray-800">Delivery Address:</p>
            <p class="text-gray-600"><?= $fetch_item_orders[0]['delivery_address']; ?></p>
        </div>
        
        <!-- Products List -->
        <?php foreach ($fetch_item_orders as $item):
            $promo_discount = json_decode($item['promo_discount'], true); // true returns an associative array
        ?>
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="order-image flex justify-center items-center">
                        <img src="../upload/<?= $item['prod_image']; ?>" alt="Product Image" class="w-32 h-32 object-cover rounded-lg shadow-lg border border-gray-200">
                    </div>
                    <!-- Product Details -->
                    <div class="order-details space-y-2">
                        <p class="font-semibold text-lg text-gray-700"><?= $item['prod_name']; ?></p>
                        <p class="text-gray-600 text-sm"><?= $item['prod_description']; ?></p>
                    </div>
                    <!-- Price and Category -->
                    <div class="order-price space-y-2">

                    <?php if($promo_discount['promoRate']){?>
                      <p class="font-semibold text-lg text-gray-700">Discounted Price:<?= $item['item_product_price']-($item['item_product_price']*$promo_discount['promoRate']); ?></p>
                    <?php } ?>
                      
                        
                        <p class="font-semibold text-lg text-gray-700">Original Price:<?= $item['item_product_price']; ?></p>
                        <p class="font-semibold text-lg text-gray-700">Quantity:<?= $item['item_qty']; ?></p>
                        <p class="font-semibold text-lg text-gray-700">Category:<?= $item['category_name']; ?></p>
                        <?php if($promo_discount['promoRate']){
                            ?>
                        <p class="font-semibold text-lg text-gray-700">Promo:<?= $promo_discount['promoName']; ?> <?= ($promo_discount['promoRate']*100); ?>%</p>
                        <?php } ?>
                    </div>
                    <!-- Product Image -->
                   
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php else: ?>
    <div class="container mx-auto p-6">
        <p class="text-center text-gray-500 text-lg">No record found.</p>
    </div>
<?php endif; ?>
