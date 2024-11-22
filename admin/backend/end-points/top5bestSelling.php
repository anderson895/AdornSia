<?php
include('../class.php');
$db = new global_class();

// Fetch the top 5 best-selling products
$orders = $db->top5bestSelling();

header('Content-Type: application/json');

if ($orders) {
    echo json_encode($orders);
} else {
    // Log the error message to a file
    error_log('Error in top5bestSelling: ' . $db->conn->error);

    // Return the error message to the client
    echo json_encode(['error' => 'No data available or an error occurred']);
}
?>
