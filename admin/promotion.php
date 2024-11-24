<?php 
include "components/header.php";
?>

<!-- Header Section -->
<div class="flex justify-between items-center bg-white p-6 mb-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800">Marketing Promotions</h2>
    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-xl font-bold text-white">
        <?php
        echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
        ?>
    </div>
</div>

<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Customer List</h3>

    <div class="legend mb-4 text-sm text-gray-600">
        <ul>
            <li><span class="text-green-600">&#8226;</span> Active Promotions</li>
            <li><span class="text-red-600">&#8226;</span> Expired Promotions</li>
        </ul>
    </div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Promo</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Rate</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Expiration</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/promotional_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "components/footer.php";?>
