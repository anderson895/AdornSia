<?php 

include "components/header.php";

// Set the default step as "Pending" if not set
$defaultStep = 'Pending'; // Default value



if (isset($_GET['step'])) {
    $defaultStep = $_GET['step'];
}else{
    echo "<script>location.href='orderlist.php?step=Pending'</script>";
}
?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">List of orders</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
        ?>
    </div>
</div>

<div class="overflow-x-auto bg-white shadow-md rounded-lg p-6" >
    <h2 class="text-xl font-semibold text-gray-700 mb-4"></h2>

  <!-- Tabs -->
  <div class="flex justify-center items-center flex-wrap space-x-0 space-y-2 md:space-y-0 md:space-x-4 border-b mb-6">
      <a href="?step=Pending" class="py-2 px-4 text-gray-600 hover:text-red-500 <?= ($defaultStep == 'Pending' ? 'border-b-2 border-red-500 text-red-500' : '') ?>">Pending</a>
      <a href="?step=Accept" class="py-2 px-4 text-gray-600 hover:text-red-500 <?= ($defaultStep == 'Accept' ? 'border-b-2 border-red-500 text-red-500' : '') ?>">Accept</a>
      <a href="?step=Shipped" class="py-2 px-4 text-gray-600 hover:text-red-500 <?= ($defaultStep == 'Shipped' ? 'border-b-2 border-red-500 text-red-500' : '') ?>">Shipped</a>
      <a href="?step=Delivered" class="py-2 px-4 text-gray-600 hover:text-red-500 <?= ($defaultStep == 'Delivered' ? 'border-b-2 border-red-500 text-red-500' : '') ?>">Delivered</a>
      <a href="?step=Canceled" class="py-2 px-4 text-gray-600 hover:text-red-500 <?= ($defaultStep == 'Canceled' ? 'border-b-2 border-red-500 text-red-500' : '') ?>">Cancelled</a>
    </div>

    <!-- border-b-2 border-red-500 text-red-500 -->
    <!-- Search Box and Table -->
    <div class="flex justify-between items-center mb-4">
        <input type="text" id="searchInput" placeholder="Search..." class="w-1/4 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm">
    </div>

    <table class="min-w-full table-auto">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Code</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Customer</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Order Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Payment</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Subtotal</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Vat</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Total</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Address</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
            </tr>
        </thead>
        <tbody id="recordTable">
        </tbody>
    </table>
</div>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php include "components/footer.php";?>

<script src="js/table_order.js"></script>
