<?php 
include "components/header.php";
$salesReport = $db->SalesReport();
?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Sales Report</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php echo substr(ucfirst($_SESSION['admin_username']), 0, 1); ?>
    </div>
</div>

<!-- Card for Report Filter & Export -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <div class="flex justify-between items-center space-x-4 mb-4">
        <form method="GET" action="../function/export_report.php" class="flex items-center space-x-4 w-full md:w-auto">
            
            <!-- Report Type Selector -->
            <select name="report_type" id="report_type" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="daily">Daily Report</option>
                <option value="weekly">Weekly Report</option>
                <option value="monthly">Monthly Report</option>
                <option value="yearly">Yearly Report</option>
            </select>

            <!-- Year Range Inputs (Visible only for Yearly Report) -->
            <div id="year_range" class="hidden space-x-2">
                <input type="number" name="start_year" placeholder="Start Year" class="px-4 py-2 border border-gray-300 rounded-md" min="2000" max="2100" />
                <input type="number" name="end_year" placeholder="End Year" class="px-4 py-2 border border-gray-300 rounded-md" min="2000" max="2100" />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="rounded bg-blue-500 text-white px-4 py-2 flex items-center space-x-2">
                <span class="material-icons">download</span>
                <span>Export</span>
            </button>


            <button onclick="printReport()" class="px-4 py-2 bg-green-500 text-white rounded-md flex items-center space-x-2">
                <span class="material-icons">print</span>
                <span>Print</span>
            </button>
        </form>
    </div>
</div>

<!-- Sales Overview Table -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6" id="printableArea">
    <h1 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b text-left">Date</th>
                    <th class="py-2 px-4 border-b text-left">Product</th>
                    <th class="py-2 px-4 border-b text-left">Quantity Sold</th>
                    <th class="py-2 px-4 border-b text-left">Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($salesReport && count($salesReport) > 0) {
                    foreach ($salesReport as $report) {
                ?>
                <tr>
                    <td class="py-2 px-4 border-b">
                        <?= htmlspecialchars((new DateTime($report['order_date']))->format('F j, Y, g:i a')) ?>
                    </td>
                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($report['product']) ?></td>
                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($report['total_quantity_sold']) ?></td>
                    <td class="py-2 px-4 border-b">Php <?= number_format($report['total_revenue'], 2) ?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='4' class='py-2 px-4 border-b text-center'>No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "components/footer.php"; ?>
<script>


$(document).ready(function() {
    $('#report_type').change(function() {
        var yearRangeDiv = $('#year_range');
        if ($(this).val() === 'yearly') {
            yearRangeDiv.removeClass('hidden');
        } else {
            yearRangeDiv.addClass('hidden');
        }
    });
});

    // Function to print the content
    function printReport() {
        var printContent = document.getElementById('printableArea').innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>
