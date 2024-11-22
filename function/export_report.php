<?php
include "../admin/backend/class.php";

// Create an instance of the SalesReport class
$db = new global_class();

// Get the report type and year range from the query parameters
$reportType = isset($_GET['report_type']) ? $_GET['report_type'] : 'daily';
$startYear = isset($_GET['start_year']) ? $_GET['start_year'] : null;
$endYear = isset($_GET['end_year']) ? $_GET['end_year'] : null;

// Define a function to fetch the sales report data based on the report type
function getSalesReportData($reportType, $startYear, $endYear) {
    global $db;

    // Modify query based on the report type and year range
    return $db->getSalesReport($reportType, $startYear, $endYear); 
}

// Get the sales report data based on the selected report type and year range
$salesReportData = getSalesReportData($reportType, $startYear, $endYear);

// Create a file pointer connected to the output stream
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sales_report.csv"');
$output = fopen('php://output', 'w');

// Add a title based on the report type
switch ($reportType) {
    case 'daily':
        $reportTitle = "Daily Sales Report";
        break;
    case 'weekly':
        $reportTitle = "Weekly Sales Report";
        break;
    case 'monthly':
        $reportTitle = "Monthly Sales Report";
        break;
    case 'yearly':
        $reportTitle = "Yearly Sales Report";
        break;
    default:
        $reportTitle = "Sales Report";
}

// Add the title row to the CSV
fputcsv($output, [$reportTitle]);

// Add a label row with the report period
$dateRange = '';
switch ($reportType) {
    case 'daily':
        $dateRange = 'Date Range: ' . date('F j, Y');
        break;
    case 'weekly':
        $dateRange = 'Date Range: ' . date('F j, Y', strtotime('last Sunday')) . ' - ' . date('F j, Y');
        break;
    case 'monthly':
        $dateRange = 'Date Range: ' . date('F, Y');
        break;
    case 'yearly':
        $dateRange = 'Date Range: ' . $startYear . ' - ' . $endYear;
        break;
}
fputcsv($output, [$dateRange]);

// Add column headers for the CSV
fputcsv($output, ['Date', 'Product', 'Quantity Sold', 'Revenue']);

// Add data rows to the CSV
if ($salesReportData) {
    foreach ($salesReportData as $report) {
        fputcsv($output, [
            (new DateTime($report['order_date']))->format('F j, Y, g:i a'),
            $report['product'],
            $report['total_quantity_sold'],
            number_format($report['total_revenue'], 2)
        ]);
    }
}

// Close the file pointer
fclose($output);
exit();
?>
