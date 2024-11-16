<?php 
session_start();
include "components/header.php";
include('backend/class.php');

$db = new global_class();
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
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Orders Record For <span id="statusOrder"></span></h2>

    <div class="flex justify-between items-center mb-4">
        <input type="text" id="searchInput" placeholder="Search..." class="w-1/4 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-sm">
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            Add New Order
        </button>
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
