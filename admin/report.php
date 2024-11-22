<?php 
include "components/header.php";

?>
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Sales Report</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($_SESSION['admin_username']), 0, 1); ?>
    </div>
</div>

<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-700">Product List</h3>
        <!-- Add Product Button -->
        <button id="addProductButton" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Add Product
        </button>
    </div>











<?php include "components/footer.php";?>


