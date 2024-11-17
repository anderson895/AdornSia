
<div class="flex flex-col lg:flex-row">
 

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Tabs -->
  
    <!-- Order Cards -->
    <div class="space-y-4">
      <!-- Order 1 -->
      <?php 

    $order_id=$_GET['order_id'];

    $fetch_orders = $db->fetch_order_item($userID,$order_id);  
    foreach ($fetch_orders as $order):
        $promo_discount = json_decode($order['promo_discount'], true);
    ?>
      <div class="bg-white shadow rounded-lg p-4">
        
        <div class="flex flex-wrap items-center gap-4">
          <img src="https://via.placeholder.com/80" alt="Product Image" class="w-20 h-20 object-cover">
          <div>
            <h3 class="font-bold"><?=ucfirst($order['prod_name'])?></h3>
           <p class="text-sm text-gray-600">Qty: <?=$order['item_qty']?> <?php echo ($order['item_size'] == "N/A") ? "" : $order['item_size']; ?></p>

           <?php if($promo_discount['promoRate']){?>
                            <p class="font-semibold text-lg text-gray-700">Discounted Price: <span class="text-red-600"><?= $order['item_product_price']-($order['item_product_price']*$promo_discount['promoRate']); ?></span></p>
                        <?php } ?>
                        <p class="font-semibold text-lg text-gray-700">Original Price: <span class="text-gray-600"><?= $order['item_product_price']; ?></span></p>
                        <p class="font-semibold text-lg text-gray-700">Quantity: <span class="text-gray-600"><?= $order['item_qty']; ?></span></p>
                        <p class="font-semibold text-lg text-gray-700">Category: <span class="text-gray-600"><?= $order['category_name']; ?></span></p>
                        <?php if($promo_discount['promoRate']){?>
                            <p class="font-semibold text-lg text-gray-700">Promo: <span class="text-green-600"><?= $promo_discount['promoName']; ?> <?= ($promo_discount['promoRate']*100); ?>%</span></p>
                        <?php } ?>
          </div>
        </div>
        <div class="flex flex-wrap justify-between items-center mt-4 gap-2">
          <p class="text-sm text-gray-600">Cancelled automatically by Shopee's system</p>
       
          <button class="bg-red-500 text-white px-4 py-2 rounded btnAddToCart"
          data-product_id="<?=$order['item_product_id']?>"
          data-user_id="<?=$userID?>"
          >Buy Again</button>
        </div>
      </div>
      <?php endforeach; ?>
     
    </div>
  </main>
</div>
