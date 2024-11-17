<div class="flex flex-col lg:flex-row items-center justify-center">
  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Tabs -->

    <!-- Order Cards -->
    <div class="space-y-6">
      <!-- Order 1 -->
      <?php 
        $order_id = $_GET['order_id'];
        $fetch_orders = $db->fetch_order_item($userID, $order_id);  
        foreach ($fetch_orders as $order):
            $promo_discount = json_decode($order['promo_discount'], true);
      ?>
      <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto relative">

        <!-- Product Details Section -->
        <div class="flex flex-col lg:flex-row items-center justify-center gap-6">
          <!-- Product Image -->
          <img src="../upload/<?=$order['prod_image']?>" alt="Product Image" class="w-40 h-40 object-cover rounded-lg mx-auto lg:mx-0">

          <div class="flex-1 text-center lg:text-left">
            <h3 class="text-2xl font-semibold text-gray-800"><?= ucfirst($order['prod_name']) ?></h3>
            <p class="text-sm text-gray-500 mt-1">Qty: <?=$order['item_qty']?> <?php echo ($order['item_size'] == "N/A") ? "" : $order['item_size']; ?></p>

            <?php if ($promo_discount['promoRate']) { ?>
                <p class="text-lg font-semibold text-gray-700 mt-2">Discounted Price: 
                  <span class="text-red-600"><?= $order['item_product_price'] - ($order['item_product_price'] * $promo_discount['promoRate']); ?></span>
                </p>
            <?php } ?>
            <p class="text-lg font-semibold text-gray-700 mt-2">Original Price: 
              <span class="text-gray-600"><?= $order['item_product_price']; ?></span>
            </p>
            <p class="text-lg font-semibold text-gray-700 mt-2">Quantity: 
              <span class="text-gray-600"><?= $order['item_qty']; ?></span>
            </p>
            <p class="text-lg font-semibold text-gray-700 mt-2">Category: 
              <span class="text-gray-600"><?= $order['category_name']; ?></span>
            </p>
            <?php if ($promo_discount['promoRate']) { ?>
                <p class="text-lg font-semibold text-gray-700 mt-2">Promo: 
                  <span class="text-green-600"><?= $promo_discount['promoName']; ?> <?= ($promo_discount['promoRate'] * 100); ?>%</span>
                </p>
            <?php } ?>
            <p class="text-lg font-semibold text-gray-700 mt-2">Total: 
              <span class="text-gray-600"><?= $order['item_total']; ?></span>
            </p>
          </div>
        </div>

        <!-- Buttons Container -->
        <div class="w-full mt-6">
          <!-- Return/Refund Button (conditionally displayed) -->
          <?php if ($order['order_status'] == "Delivered") { ?>
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0 w-full items-center justify-center">
              <button class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-600 transition-colors duration-300 w-full sm:w-auto 
              btnAddToCart"
              data-product_id="<?=$order['item_product_id']?>"
              data-user_id="<?=$userID?>"
              >
                Buy Again
              </button>
              <button class="bg-gray-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-600 transition-colors duration-300 w-full sm:w-auto">
                Return/Refund
              </button>
            </div>
          <?php } ?>
        </div>

      </div>
      <?php endforeach; ?>
    </div>
  </main>
</div>
