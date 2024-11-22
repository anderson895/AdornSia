<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Dashboard</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
        ?>
    </div>
</div>

<!-- Dashboard Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
    <!-- Card for Total Customer -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="assets/service.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Customer</h3>
        <p class="text-blue-500 text-2xl font-bold count_users">3</p>
    </div>

    <!-- Card for Total Sales -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="assets/sales.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Sales</h3>
        <p class="text-blue-500 text-2xl font-bold totalSales">0</p>
    </div>

    <!-- Card for No of Orders -->
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="assets/cargo.png" alt="students icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">No of Orders</h3>
        <p class="text-blue-500 text-2xl font-bold numOrders" id="numOrders">0</p>
    </div>
</div>




<!-- Sales Performance Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
    <!-- Daily Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Daily)</h3>
        <!-- Placeholder for Daily Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="daily_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

    <!-- Weekly Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Weekly)</h3>
        <!-- Placeholder for Weekly Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="weekly_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

    <!-- Monthly Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Monthly)</h3>
        <!-- Placeholder for Monthly Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="monthly_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>
</div>


<!-- Horizontal Scrollable Cards for Product Categories -->
<div class="mt-8">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 w-full mx-auto justify-center">
        <!-- Best Selling Products Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full" id="bestSellingProducts">
        </div>

        <!-- New Products Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full" id="NewProduct">
        </div>

        <!-- Inventory Status Low Stock Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full" id="stock_status">
        </div>
    </div>
</div>




<?php include "components/footer.php";?>

<script src="js/topNewProduct.js"></script>
<script src="js/top5bestSelling.js"></script>
<script src="js/analytics.js"></script>
<script src="js/daily_sales.js"></script>
<script src="js/weekly_sales.js"></script>
<script src="js/monthly_sales.js"></script>
<script src="js/stock_status.js"></script>
