<?php 
include('../../backend/class.php');

$db = new global_class(); // connections



// Assuming you have an 'accomodation_id' in your POST data
$rate_prod_id = isset($_POST['rate_prod_id']) ? $_POST['rate_prod_id'] : '';

if (!empty($rate_prod_id)) {
    $result = $db->getAllReviewsInAccom($rate_prod_id);
    $reviews = $result->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($reviews);
} else {
    // Handle the case where 'accomodation_id' is not provided in the POST data
    echo json_encode(['error' => 'Accomodation ID not provided']);
}
?>
