<?php
include "../admin/backend/class.php";

// Create an instance of the SalesReport class
$db = new global_class();

// Get the report type from the query parameter
$reportType = isset($_GET['report_type']) ? $_GET['report_type'] : 'daily';

// Define a function to fetch the sales report data based on the report type
function getSalesReportData($reportType) {
    global $db;

    // Prepare the query with a date range filter
    $dateFilter = '';
    $currentDate = date('Y-m-d'); // Get today's date

    switch ($reportType) {
        case 'daily':
            $dateFilter = "WHERE DATE(o.order_date) = CURDATE()"; // Get today's data
            break;
        case 'weekly':
            $dateFilter = "WHERE YEARWEEK(o.order_date, 1) = YEARWEEK(CURDATE(), 1)"; // Get the current week's data
            break;
        case 'monthly':
            $dateFilter = "WHERE MONTH(o.order_date) = MONTH(CURDATE()) AND YEAR(o.order_date) = YEAR(CURDATE())"; // Get this month's data
            break;
        case 'yearly':
            $dateFilter = "WHERE YEAR(o.order_date) = YEAR(CURDATE())"; // Get this year's data
            break;
    }

    // SQL query to get total revenue and quantity sold with date filtering
    $query = "
        SELECT 
            p.prod_name AS product, 
            o.order_date,
            SUM(oi.item_total) AS total_revenue, 
            SUM(oi.item_qty) AS total_quantity_sold
        FROM orders_item oi
        JOIN orders o ON oi.item_order_id = o.order_id
        LEFT JOIN product p ON oi.item_product_id = p.prod_id
        WHERE o.order_status = 'Delivered'
        $dateFilter
        GROUP BY p.prod_id, o.order_date
    ";

    // Execute the query
    $result = $db->conn->query($query);

    if ($result) {
        // Fetch all the rows and return them as an array
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Log the error for debugging
        error_log('Database query failed: ' . $db->conn->error);
        echo json_encode(['error' => 'Failed to retrieve data']);
        return [];  // Return an empty array in case of error
    }
}

// Get the sales report data based on the selected report type
$salesReportData = getSalesReportData($reportType);

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

// Add a label row with the report period (optional: customize further)
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
        $dateRange = 'Date Range: ' . date('Y');
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
