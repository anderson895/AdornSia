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
    }else if ($_POST['requestType']=="OrderRequest") {

     // Retrieve basic fields from POST
$selectedAddress = $_POST['selectedAddress'];
$selectedPaymentMethod = $_POST['selectedPaymentMethod'];
$subtotal = $_POST['subtotal'];
$vat = $_POST['vat'];
$total = $_POST['total'];

// Handle file upload if a file was provided
$selectedFilePath = null;
$uniqueFileName = null;  // Initialize uniqueFileName to null by default
$fileTmpPath = null; // Initialize the fileTmpPath to null

if (isset($_FILES['selectedFile']) && $_FILES['selectedFile']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['selectedFile']['tmp_name'];
    $fileName = $_FILES['selectedFile']['name'];
    $uploadDir = '../proofPayment/';

    // Generate a unique filename to prevent overwriting
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('proof_', true) . '.' . $fileExtension;

    // Set the full path for the file in the uploads directory
    $selectedFilePath = $uploadDir . $uniqueFileName;
} else {
    // No file uploaded, set both proof_of_payment and filename to null
    $uniqueFileName = null;
    $selectedFilePath = null;
}

// Process the order request in the database
$response = $db->OrderRequest($selectedAddress, $selectedPaymentMethod, $uniqueFileName, $selectedFilePath, $subtotal, $vat, $total);

if ($response['status'] === 'success') {
    // Create the directory if it doesn't exist
    if ($selectedFilePath && !is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Only proceed if a file was uploaded
    if ($selectedFilePath && isset($fileTmpPath) && is_uploaded_file($fileTmpPath)) {
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($fileTmpPath, $selectedFilePath)) {
            echo json_encode(['status' => 'success', 'message' => 'Order processed and file saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Order processed but file upload failed.']);
        }
    } else {
        // If no file was uploaded, send success message for order processing
        echo json_encode(['status' => 'success', 'message' => 'Order processed without file upload.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Order request failed.']);
}





    }

}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = $db->getPaymentQr();
    echo json_encode(['status' => $response]);
}



 
 ?>
     