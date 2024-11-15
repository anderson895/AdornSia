<?php 
session_start();
include "components/header.php";
include('backend/class.php');

$db = new global_class();

// Set the default step as "Pending" if not set
$defaultStep = 'Pending'; // Default value



if (isset($_GET['step'])) {
    $defaultStep = $_GET['step'];
}else{
    echo "<script>location.href='orderlist.php?step=Pending'</script>";
}
?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">List Of Orders</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
        ?>
    </div>
</div>

<div class="overflow-x-auto bg-white shadow-md rounded-lg p-6" id="recordTable">
    <h2 class="text-xl font-semibold text-gray-700 mb-4"></h2>

    <!-- Centering the order status steps -->
    <div class="flex justify-center items-center w-full max-w-4xl space-x-6 px-4 py-6 mx-auto">
        <!-- Step 1: Pending -->
        <a href="?step=Pending" class="flex items-center space-x-2 p-2 rounded-md <?= ($defaultStep == 'Pending' ? 'bg-green-600' : 'bg-green-500') ?> text-white hover:bg-green-600 focus:outline-none">
            <div class="w-8 h-8 bg-white text-green-500 flex items-center justify-center rounded-full">
                <span class="material-icons text-lg">pending_actions</span>
            </div>
            <span class="text-white font-medium text-sm">Pending</span>
        </a>

        <!-- Line -->
        <div class="flex-1 border-t-2 border-green-500"></div>

        <!-- Step 2: Accept -->
        <a href="?step=Accept" class="flex items-center space-x-2 p-2 rounded-md <?= ($defaultStep == 'Accept' ? 'bg-green-600' : 'bg-green-500') ?> text-white hover:bg-green-600 focus:outline-none">
            <div class="w-8 h-8 bg-white text-green-500 flex items-center justify-center rounded-full">
                <span class="material-icons text-lg">check</span>
            </div>
            <span class="text-white font-medium text-sm">Accept</span>
        </a>

        <!-- Line -->
        <div class="flex-1 border-t-2 border-green-500"></div>

        <!-- Step 3: Shipped -->
        <a href="?step=Shipped" class="flex items-center space-x-2 p-2 rounded-md <?= ($defaultStep == 'Shipped' ? 'bg-green-600' : 'bg-green-500') ?> text-white hover:bg-green-600 focus:outline-none">
            <div class="w-8 h-8 bg-white text-green-500 flex items-center justify-center rounded-full">
                <span class="material-icons text-lg">local_shipping</span>
            </div>
            <span class="text-white font-medium text-sm">Shipped</span>
        </a>

        <!-- Line -->
        <div class="flex-1 border-t-2 border-green-500"></div>

        <!-- Step 4: Delivered -->
        <a href="?step=Delivered" class="flex items-center space-x-2 p-2 rounded-md <?= ($defaultStep == 'Delivered' ? 'bg-green-600' : 'bg-green-500') ?> text-white hover:bg-green-600 focus:outline-none">
            <div class="w-8 h-8 bg-white text-green-500 flex items-center justify-center rounded-full">
                <span class="material-icons text-lg">handshake</span>
            </div>
            <span class="text-white font-medium text-sm">Delivered</span>
        </a>

        <!-- Line -->
        <div class="flex-1 border-t-2 border-green-500"></div>

        <!-- Step 5: Canceled -->
        <a href="?step=Canceled" class="flex items-center space-x-2 p-2 rounded-md <?= ($defaultStep == 'Canceled' ? 'bg-green-600' : 'bg-green-500') ?> text-white hover:bg-green-600 focus:outline-none">
            <div class="w-8 h-8 bg-white text-green-500 flex items-center justify-center rounded-full">
                <span class="material-icons text-lg">event_busy</span>
            </div>
            <span class="text-white font-medium text-sm">Canceled</span>
        </a>
    </div>

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
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php include "components/footer.php";?>

<script src="js/table_order.js"></script>
