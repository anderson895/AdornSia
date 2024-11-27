<?php 
$orderId = $_GET['orderId'];
$fetch_item_orders = $db->fetch_item_orders($orderId);

// Check if there are any items in the array
if (count($fetch_item_orders) > 0): 
    // Format the order date
    $orderDate = new DateTime($fetch_item_orders[0]['order_date']);
    $formattedDate = $orderDate->format('F j, Y g:i A'); // MONTH DAY YEAR Time format
?>

<div class="container mx-auto px-4 py-6 bg-gray-50 rounded-lg shadow-xl">
    <!-- Status Update Section -->
    <div class="mb-6 flex justify-end">
        <div class="relative w-full md:w-1/3">
            <select 
                class="UpdateOrderStatus w-full p-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                data-orderId="<?= $orderId ?>" 
                data-initial-status="<?= $fetch_item_orders[0]['order_status']; ?>">
                <?php if ($fetch_item_orders[0]['order_status'] == "Pending"){ ?>
                    <option <?= $fetch_item_orders[0]['order_status'] == "Pending" ? "selected" : "" ?> value="Pending">Pending</option>
                    <option <?= $fetch_item_orders[0]['order_status'] == "Accept" ? "selected" : "" ?> value="Accept">Accept</option>
                <?php } else if ($fetch_item_orders[0]['order_status'] == "Accept"){ ?>
                    <option <?= $fetch_item_orders[0]['order_status'] == "Accept" ? "selected" : "" ?> value="Accept">Accept</option>
                    <option value="Shipped" <?= $fetch_item_orders[0]['order_status'] == "Shipped" ? "selected" : "" ?>>Shipped</option>
                    <option value="Delivered" <?= $fetch_item_orders[0]['order_status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                    <option value="Canceled" <?= $fetch_item_orders[0]['order_status'] == "Canceled" ? "selected" : "" ?>>Canceled</option>
                <?php } else { ?>
                    <option value="Shipped" <?= $fetch_item_orders[0]['order_status'] == "Shipped" ? "selected" : "" ?>>Shipped</option>
                    <option value="Delivered" <?= $fetch_item_orders[0]['order_status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                    <option value="Canceled" <?= $fetch_item_orders[0]['order_status'] == "Canceled" ? "selected" : "" ?>>Canceled</option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Order Information -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 p-4 rounded-lg shadow-md">
            <p class="font-semibold text-gray-700">Order Code:</p>
            <p class="text-gray-600"><?= $fetch_item_orders[0]['order_code']; ?></p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg shadow-md">
            <p class="font-semibold text-gray-700">Status:</p>
            <p class="text-gray-600"><?= $fetch_item_orders[0]['order_status']; ?></p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg shadow-md">
            <p class="font-semibold text-gray-700">Order Date:</p>
            <p class="text-gray-600"><?= $formattedDate; ?></p>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
    <p class="font-semibold text-lg text-gray-800">
        Payment:  
        <span class="text-lg text-gray-800 font-medium">
            <?php 
                if ($fetch_item_orders[0]['mode_of_payment'] != "cod") {
                    echo ucfirst($fetch_item_orders[0]['mode_of_payment']);
                } else {
                    echo "Cash on Delivery";
                }
            ?>
        </span>
    </p>

  
    <?php if ($fetch_item_orders[0]['mode_of_payment'] != "cod"): ?>
        <div class="mt-4 flex justify-center">
            <img src="../proofPayment/<?= $fetch_item_orders[0]['proof_of_payment'] ?>" alt="Proof of Payment" class="w-full max-w-sm rounded-lg shadow-md">
        </div>
    <?php endif; ?>
</div>


    <!-- Order Summary Section -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <p class="font-semibold text-lg text-gray-800">Subtotal:</p>
            <p class="font-semibold text-lg text-gray-800 text-right">₱ <?= number_format($fetch_item_orders[0]['subtotal'], 2); ?></p>
        </div>
        
        <div class="flex justify-between items-center">
            <p class="font-semibold text-lg text-gray-800">VAT:</p>
            <p class="font-semibold text-lg text-gray-800 text-right">₱ <?= number_format($fetch_item_orders[0]['vat'], 2); ?></p>
        </div>

        <div class="flex justify-between items-center">
            <p class="font-semibold text-lg text-gray-800">Shipping fee:</p>
            <p class="font-semibold text-lg text-gray-800 text-right">₱ <?= number_format(50, 2); ?></p>
        </div>

        <div class="flex justify-between items-center">
            <p class="font-semibold text-lg text-gray-800">Total:</p>
            <p class="font-semibold text-lg text-gray-800 text-right">₱ <?= number_format($fetch_item_orders[0]['total'], 2); ?></p>
        </div>
    </div>


    <!-- Delivery Address -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <p class="font-semibold text-lg text-gray-800">Delivery Address:</p>
        <p class="text-gray-600"><?= $fetch_item_orders[0]['delivery_address']; ?></p>
    </div>

    <!-- Products List -->
    <?php foreach ($fetch_item_orders as $item): 
        $promo_discount = json_decode($item['promo_discount'], true); // true returns an associative array
    ?>
        <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Product Image -->
                <div class="flex justify-center items-center">
                    <img src="../upload/<?= $item['prod_image']; ?>" alt="Product Image" class="w-24 h-24 object-cover rounded-lg shadow-md">
                </div>
                <!-- Product Details -->
                <div class="space-y-2">
                    <p class="font-semibold text-lg text-gray-700"><?= $item['prod_name']; ?></p>
                    <p class="text-gray-600"><?= $item['prod_description']; ?></p>
                </div>
                <!-- Price and Category -->
                <div class="space-y-2">
                    <?php if ($promo_discount['promoRate']): ?>
                        <p class="font-semibold text-gray-700">Discounted Price:</p>
                        <p class="text-red-600">
                         ₱ <?= $item['item_product_price'] - ($item['item_product_price'] * $promo_discount['promoRate']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <p class="font-semibold text-gray-700">Original Price:</p>
                    <p class="text-gray-600 <?= $promo_discount['promoRate'] ? 'line-through' : '' ?>">₱<?= $item['item_product_price']; ?></p>
                    
                    <p class="font-semibold text-gray-700">Quantity:</p>
                    <p class="text-gray-600"><?= $item['item_qty']; ?></p>
                    
                    <p class="font-semibold text-gray-700">Category:</p>
                    <p class="text-gray-600"><?= $item['category_name']; ?></p>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php else: ?>

<div class="container mx-auto px-4 py-6 text-center">
    <p class="text-gray-500 text-lg">No record found.</p>
</div>

<?php endif; ?>
