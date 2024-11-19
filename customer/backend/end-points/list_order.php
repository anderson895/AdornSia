<div class="flex flex-col lg:flex-row gap-6">
  <!-- Main Content -->
  <main class="flex-1 p-6 bg-gray-50 rounded-lg shadow-lg">
    <!-- Tabs -->
    <div class="flex justify-center space-x-4 space-y-2 md:space-y-0 md:space-x-4 border-b mb-6 overflow-x-auto whitespace-nowrap">
      <a href="#" class="py-2 px-4 border-b-2 border-transparent text-gray-600 hover:text-red-500 hover:border-red-500 font-semibold transition-all duration-200" data-status="all">All</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500 font-semibold transition-all duration-200" data-status="pending">Pending</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500 font-semibold transition-all duration-200" data-status="accept">To Ship</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500 font-semibold transition-all duration-200" data-status="shipped">To Receive</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500 font-semibold transition-all duration-200" data-status="delivered">Completed</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500 font-semibold transition-all duration-200" data-status="canceled">Cancelled</a>
    </div>

    <!-- Order Cards -->
    <div class="space-y-6">
      <?php 
      // Fetch the orders
      $fetch_orders = $db->fetch_order($userID);
      
      // Check if there are any orders
      if ($fetch_orders->num_rows > 0): 
        while ($order = $fetch_orders->fetch_assoc()):
          // Create a class based on the order status
          $orderStatusClass = strtolower(str_replace(' ', '-', $order['order_status']));
      ?>
      <div class="bg-white shadow-lg rounded-lg p-6 transition-all duration-300 hover:shadow-xl order-card <?=$orderStatusClass?>">
        <div class="flex flex-wrap items-center gap-6">
          <div>
            <p class="text-sm text-gray-600 mb-3">Order Date: <?=$order['order_date']?></p>
            <p class="font-bold text-xl text-gray-900"># <?=$order['order_code']?></p>
            <p class="text-sm text-gray-600 mt-1">Subtotal: <?=$order['subtotal']?></p>
            <p class="text-sm text-gray-600 mt-1">Vat: <?=$order['vat']?></p>
            <p class="text-sm text-gray-600 mt-1">Total: <?=$order['total']?></p>
            <p class="text-sm text-gray-600 mt-1">Status: <span class="font-semibold text-red-500"><?=$order['order_status']?></span></p>
          </div>
        </div>

        <div class="flex flex-wrap justify-between items-center mt-4 gap-4">
          <p class="text-sm text-gray-600"><?=$order['delivery_address']?></p>
         
          <div class="flex space-x-4 mt-4">
            <button class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300" onclick="location.href='view_order_details.php?order_id=<?=$order['order_id']?>'">View Details</button>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
      <?php else: ?>
      <!-- No Order History Message -->
      <div class="bg-white shadow-lg rounded-lg p-6 text-center text-gray-600">
        <p class="text-xl font-semibold">No Order History</p>
        <p class="mt-4 text-sm">You haven't placed any orders yet. Browse products and start shopping!</p>
      </div>
      <?php endif; ?>
    </div>
  </main>
</div>

<script>
  $(document).ready(function() {
    // Filter orders based on selected tab
    $('a[data-status]').on('click', function(e) {
      e.preventDefault();

      // Get the selected status from the data-status attribute
      var status = $(this).data('status');

      // Highlight the active tab
      $('a[data-status]').removeClass('border-red-500 text-red-500');
      $(this).addClass('border-red-500 text-red-500');

      // Show all orders or filter by status
      if (status === 'all') {
        $('.order-card').show();
      } else {
        $('.order-card').hide();
        $('.order-card.' + status).show();
      }
    });
  });
</script>
