<?php
// Disable error reporting temporarily to avoid unwanted output
error_reporting(0);  // Turn off all PHP error reporting
ini_set('display_errors', 0);  // Prevent errors from being displayed

include('../class.php');
$db = new global_class();

// Fetch the top 5 best-selling products
$orders = $db->top5bestSelling();

header('Content-Type: application/json');

if ($orders) {
    // Output the products in a valid JSON format
    echo json_encode($orders);
} else {
    // Output a valid JSON error message
    echo json_encode(['error' => 'No data available or an error occurred']);
}
?>
