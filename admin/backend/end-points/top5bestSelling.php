<?php
include('../class.php');
$db = new global_class();

// Fetch the top 5 best-selling products
$orders = $db->top5bestSelling();

header('Content-Type: application/json');

if ($orders) {
    echo json_encode($orders);  // Return product list as JSON
} else {
    // Only output one error JSON object, not an extra message
    echo json_encode(['error' => 'No data available or an error occurred']);
}
?>
