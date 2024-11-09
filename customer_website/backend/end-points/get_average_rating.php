<?php 
include('../../backend/class.php');

$db = new global_class(); // connections



if (isset($_GET['prod_id'])) {
    $prod_id = $_GET['prod_id'];

 
    $response = $db->getAverageRating($prod_id);
  

    echo json_encode($response);
} else {
    echo json_encode(["error" => "Product ID is missing"]);
}
?>