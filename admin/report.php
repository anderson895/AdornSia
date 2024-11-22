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
    <div class="flex justify-end mb-4">
        <form method="GET" action="../function/export_report.php">

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

</div>











<?php include "components/footer.php";?>


