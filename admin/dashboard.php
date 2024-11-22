
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
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
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







<!-- Horizontal Scrollable Cards for Product Categories -->
<div class="mt-8 px-4 overflow-x-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 min-w-[600px]">
        
       <!-- Best Selling Products -->
        <div class="bg-white p-6 rounded-lg shadow-lg h-48">
          <h3 class="text-gray-700 font-semibold text-lg mb-4">Best Selling Products</h3>
            <div class="bg-white p-6 rounded-lg shadow-lg h-96 overflow-y-auto" id="bestSellingProducts">
                
                <p class="text-sm text-gray-600">Placeholder for content...</p>
            </div>
        </div>
        <!-- New Products Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg h-48">
            <h3 class="text-gray-700 font-semibold text-lg mb-4">New Products</h3>
                <div class="bg-white p-6 rounded-lg shadow-lg h-96 overflow-y-auto" id="NewProduct">
                    
                    <ul>
                        <li class="text-sm text-gray-600">Product A</li>
                        <li class="text-sm text-gray-600">Product B</li>
                        <li class="text-sm text-gray-600">Product C</li>
                        <li class="text-sm text-gray-600">Product D</li>
                        <li class="text-sm text-gray-600">Product E</li>
                        <li class="text-sm text-gray-600">Product F</li>
                    </ul>
                </div>
        </div>

        <!-- Inventory Status Low Stock Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-gray-700 font-semibold text-lg mb-4">Inventory Status (Low Stock)</h3>
            <ul>
                <li class="text-sm text-gray-600">Item X</li>
                <li class="text-sm text-gray-600">Item Y</li>
                <li class="text-sm text-gray-600">Item Z</li>
            </ul>
        </div>

        <!-- Out of Stock Products Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-gray-700 font-semibold text-lg mb-4">Out of Stock</h3>
            <ul>
                <li class="text-sm text-gray-600">Item 1</li>
                <li class="text-sm text-gray-600">Item 2</li>
            </ul>
        </div>

    </div>
</div>










<!-- Sales Performance Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
    <!-- Daily Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Daily)</h3>
        <!-- Placeholder for Daily Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="daily_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

    <!-- Weekly Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Weekly)</h3>
        <!-- Placeholder for Weekly Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="weekly_sales_chart" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

    <!-- Monthly Sales Performance Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-gray-700 font-semibold text-lg mb-4">Sales Performance (Monthly)</h3>
        <!-- Placeholder for Monthly Chart -->
        <div class="w-full h-90 bg-gray-100 rounded-lg flex justify-center items-center" style="position: relative; overflow: hidden;">
            <div id="monthly_sales_chart" style="width: 100%; height: 100%;"></div>
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
