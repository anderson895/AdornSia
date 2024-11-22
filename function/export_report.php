<?php
include "../admin/backend/db.php"; 
include "../admin/backend/class.php";

// Create an instance of the SalesReport class
$salesReport = new SalesReport($db);

// Get the report type from the query parameter
$reportType = isset($_GET['report_type']) ? $_GET['report_type'] : 'daily';

// Define a function to fetch the sales report data based on the report type
function getSalesReportData($reportType) {
    global $salesReport;

    switch ($reportType) {
        case 'daily':
            // Modify the query or filtering logic in the SalesReport class as needed
            return $salesReport->getSalesReport(); // Get all sales (customize for the report type if needed)
            break;
        case 'weekly':
            // You can modify your SQL query to filter by weekly data
            return $salesReport->getSalesReport(); // Modify as needed
            break;
        case 'monthly':
            // Modify your query for monthly data
            return $salesReport->getSalesReport(); // Modify as needed
            break;
        case 'yearly':
            // Modify your query for yearly data
            return $salesReport->getSalesReport(); // Modify as needed
            break;
        default:
            return $salesReport->getSalesReport(); // Default to all sales
    }
}

// Get the sales report data based on the selected report type
$salesReportData = getSalesReportData($reportType);

// Create a file pointer connected to the output stream
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sales_report.csv"');
$output = fopen('php://output', 'w');

// Add CSV headers
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
