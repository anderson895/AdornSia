<?php 
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['requestType']=="AddToCart") {
        $userId = $_POST['cart_user_id'];
        $productId = $_POST['cart_prod_id'];
        $prodSize = $_POST['cart_prod_size'];
        
        // Kunin ang response mula sa AddToCart method
        $response = $db->AddToCart($userId, $productId,$prodSize);
        
        // I-echo ang response upang ma-access ito sa frontend
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="MinusToCart") {
        $userId = $_POST['cart_user_id'];
        $productId = $_POST['cart_prod_id'];
        $prodSize = $_POST['cart_prod_size'];
        
        // Kunin ang response mula sa AddToCart method
        $response = $db->MinusToCart($userId, $productId,$prodSize);
        
        // I-echo ang response upang ma-access ito sa frontend
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="SaveAddress") {

        $street_name = $_POST['street_name'];
        $barangay = $_POST['barangay'];
        $complete_address_add=$_POST['complete_address_add'];
        
        // Kunin ang response mula sa AddToCart method
        $response = $db->AddAddress($street_name, $barangay,$complete_address_add);
        
        // I-echo ang response upang ma-access ito sa frontend
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="UpdateAddress") {

        $address_id = $_POST['address_id'];
        
        // Kunin ang response mula sa AddToCart method
        $response = $db->UpdateAddress($address_id);
        
        // I-echo ang response upang ma-access ito sa frontend
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="RemoveItem") {

        $cart_id = $_POST['cart_id'];
        $response = $db->RemoveItem($cart_id);
        echo json_encode(['status' => $response]);
    }
    
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = $db->getPaymentQr();
    echo json_encode(['status' => $response]);
}



 
 ?>
     