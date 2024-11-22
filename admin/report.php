<?php 
include "components/header.php";

$orders = $db->salesReport();
?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Sales Report</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($_SESSION['admin_username']), 0, 1); ?>
    </div>
</div>

<!-- Card for Report Filter & Export -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <div class="flex justify-end items-center mb-4">
        <form method="GET" action="../function/export_report.php" class="flex items-center space-x-4">
            <input hidden type="text" name="carID" value="<?=$carId?>">

            <select name="report_type" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="daily">Daily Report</option>
                <option value="weekly">Weekly Report</option>
                <option value="monthly">Monthly Report</option>
                <option value="yearly">Yearly Report</option>
            </select>

            <button type="submit" class="rounded bg-blue-500 text-white px-4 py-2">Export to Excel</button>
        </form>
    </div>








    <h1 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h1>
    <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border-b text-left">Date</th>
                <th class="py-2 px-4 border-b text-left">Product</th>
                <th class="py-2 px-4 border-b text-left">Quantity Sold</th>
                <th class="py-2 px-4 border-b text-left">Revenue</th>
                <th class="py-2 px-4 border-b text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example Row, Replace this with dynamic PHP data -->
            <tr>
                <td class="py-2 px-4 border-b">2024-11-22</td>
                <td class="py-2 px-4 border-b">Car Model A</td>
                <td class="py-2 px-4 border-b">10</td>
                <td class="py-2 px-4 border-b">$500</td>
                <td class="py-2 px-4 border-b">
                    <button class="text-blue-500 hover:text-blue-700">View</button>
                </td>
            </tr>
            
        </tbody>
    </table>
</div>


<?php include "components/footer.php"; ?>
