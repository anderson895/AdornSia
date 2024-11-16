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
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        session_start();
        $user_id = $_SESSION['user_id'];
        $cart_id = $_POST['cart_id'];
        $size = $_POST['size'];
        $response = $db->RemoveItem($user_id,$cart_id,$size);
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="OrderRequest") {

     // Retrieve basic fields from POST
$selectedAddress = $_POST['selectedAddress'];
$selectedPaymentMethod = $_POST['selectedPaymentMethod'];
$subtotal = $_POST['subtotal'];
$vat = $_POST['vat'];
$total = $_POST['total'];

// Retrieve selectedProducts from POST
$selectedProducts = $_POST['selectedProducts'] ?? null;

// Decode the JSON string into a PHP array
$selectedProductsArray = json_decode($selectedProducts, true);  // true to return as associative array

// Handle file upload if a file was provided
$selectedFilePath = null;
$uniqueFileName = null;
$fileTmpPath = null;

if (isset($_FILES['selectedFile']) && $_FILES['selectedFile']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['selectedFile']['tmp_name'];
    $fileName = $_FILES['selectedFile']['name'];
    $uploadDir = '../../../proofPayment/';

    // Generate a unique filename to prevent overwriting
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('proof_', true) . '.' . $fileExtension;

    // Validate file size and type before uploading
    $fileSize = $_FILES['selectedFile']['size'];
    $fileType = $_FILES['selectedFile']['type'];
    $maxFileSize = 10 * 1024 * 1024;  // 10MB limit
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($fileType, $allowedMimeTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
        exit;
    }

    if ($fileSize > $maxFileSize) {
        echo json_encode(['status' => 'error', 'message' => 'File size exceeds the maximum limit.']);
        exit;
    }

    // Set the full path for the file in the uploads directory
    $selectedFilePath = $uploadDir . $uniqueFileName;
} else {
    $uniqueFileName = null;
    $selectedFilePath = null;
}

// Process the order request in the database
$response = $db->OrderRequest($selectedAddress, $selectedPaymentMethod, $uniqueFileName, $selectedFilePath, $subtotal, $vat, $total);

if ($response['status'] === 'success') {
    
    $orderId = $response['order_id'];

    // Insert order items if selected products are valid
    if (is_array($selectedProductsArray) && !empty($selectedProductsArray)) {
        foreach ($selectedProductsArray as $product) {
            $itemProductId = $product['productId'];
            $itemQty = intval($product['qty']);  // Converts to integer
            $itemPrice = floatval($product['price']);  // Converts to float
            
            $itemSize = $product['size'];
        
            // Encode promo details as JSON
            $itemDiscountDetails = json_encode([
                'promoName' => $product['promoName'],
                'promoRate' => $product['promoRate']
            ]);
        
            $itemTotal = $itemQty * $itemPrice; // Calculate the total price for each product
            
            // Prepare the SQL query to insert each product into orders_item
            $insertQuery = "INSERT INTO orders_item (item_order_id, item_product_id, item_size, item_qty, item_product_price, promo_discount, item_total) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->conn->prepare($insertQuery);
            
            // Bind parameters with correct data types
            $stmt->bind_param("iisissd", $orderId, $itemProductId, $itemSize, $itemQty, $itemPrice, $itemDiscountDetails, $itemTotal);
            
            $user_id = $_SESSION['user_id'];

            $response = $db->RemoveItem($user_id,$itemProductId,$itemSize);
            // Execute the query for each product
            if (!$stmt->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert product into orders_item.']);
                exit;
            }
        }
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Selected products data is invalid.']);
        exit;
    }

    // Create the directory if it doesn't exist
    if ($selectedFilePath && !is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Only proceed if a file was uploaded
    if ($selectedFilePath && isset($fileTmpPath) && is_uploaded_file($fileTmpPath)) {
        if (move_uploaded_file($fileTmpPath, $selectedFilePath)) {
            echo json_encode(['status' => 'success', 'message' => 'Order processed and file saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Order processed but file upload failed.']);
        }
    } else {
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
     