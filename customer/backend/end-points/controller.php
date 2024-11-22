<?php 
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


include('../class.php');

$db = new global_class();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['requestType']=="RefundProduct") {

        print_r($_POST);
        $item_id =$_POST['item_id'];
        $RefundReason = $_POST['RefundReason'];

        $response = $db->RefundProduct($item_id,$RefundReason);

        echo json_encode(['status' => $response]);
        
    }else if ($_POST['requestType']=="UpdateUserPassword") {
       // Get input data from POST request
        $userID = $_POST['userID'];
        $user_NewPassword = $_POST['user_NewPassword'];
        $user_CurrentPassword = $_POST['user_CurrentPassword'];

    
            // Call the function
        $response = $db->update_user_password($userID, $user_NewPassword, $user_CurrentPassword);

        // Echo JSON encoded response
        echo json_encode($response);




    }else if ($_POST['requestType']=="UpdateUserProfile") {
    $userID = $_POST['userID'];
    $fullname = $_POST['user_fullname'];
    $email = $_POST['user_email'];
    $phone = $_POST['user_phone'];

    $db = new global_class();

    $oldImage = $db->fetch_user_profile_image($userID); 

    $profileImage = '';
    // Handle file upload with a unique filename
    if (isset($_FILES['profileimage']) && $_FILES['profileimage']['error'] == 0) {
        $uploadDir = '../../../upload/';
        $fileExtension = pathinfo($_FILES['profileimage']['name'], PATHINFO_EXTENSION);
        $uniqueFileName = uniqid('profile_', true) . '.' . $fileExtension;
        $profileImage = $uploadDir . $uniqueFileName;

        // Move the uploaded file to the designated folder
        if (move_uploaded_file($_FILES['profileimage']['tmp_name'], $profileImage)) {
            // Only delete the old image if the upload is successful
            if ($oldImage && file_exists($oldImage)) {
                unlink($oldImage); // Delete the old image
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload new profile image']);
            exit;
        }
    } else {
        // Use the old image if no new file is uploaded
        $profileImage = $oldImage;
    }

    // Update user information in the database
    $updateSuccess = $db->update_user_info($userID, $fullname, $email, $phone, $uniqueFileName);

    if ($updateSuccess) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        // If the update fails, retain the old image
        if ($profileImage !== $oldImage && file_exists($profileImage)) {
            unlink($profileImage); // Delete the newly uploaded image
        }
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }


    }else if ($_POST['requestType']=="AddToCart") {
        $userId = $_POST['cart_user_id'];
        $productId = $_POST['cart_prod_id'];
        $prodSize = $_POST['cart_prod_size'];

        $response = $db->AddToCart($userId, $productId,$prodSize);

        echo json_encode(['status' => $response]);

    }else if ($_POST['requestType']=="AddToWishlist") {
        $userId = $_POST['cart_user_id'];
        $productId = $_POST['cart_prod_id'];

        $response = $db->AddToWish($userId, $productId);

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
       
        session_start();
        $user_id = $_SESSION['user_id'];
        $cart_id = $_POST['cart_id'];
        $size = $_POST['size'];
        $response = $db->RemoveItem($user_id,$cart_id,$size);
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="RemoveFromWish") {
       
        $wish_id = $_POST['wish_id'];

        $response = $db->RemoveFromWish($wish_id);
        echo json_encode(['status' => $response]);
    }else if ($_POST['requestType']=="OrderRequest") {

     // Retrieve basic fields from POST
$selectedAddress = $_POST['selectedAddress'];
$selectedPaymentMethod = $_POST['selectedPaymentMethod'];
$subtotal = $_POST['subtotal'];
$vat = $_POST['vat'];
$total = $_POST['total'];
$sf = $_POST['sf'];

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
$response = $db->OrderRequest($selectedAddress, $selectedPaymentMethod, $uniqueFileName, $selectedFilePath, $subtotal, $vat,$sf, $total);

if ($response['status'] === 'success') {
    
    $orderId = $response['order_id'];

    if (is_array($selectedProductsArray) && !empty($selectedProductsArray)) {
        foreach ($selectedProductsArray as $product) {
            $itemProductId = $product['productId'];
            $itemQty = intval($product['qty']);  
            $itemTotalPrice =$product['price'];  // Ensure price is a float
            $originalPrice = $product['originalPrice'];
            $itemSize = $product['size'];
        
            // Encode promo details as JSON
            $itemDiscountDetails = json_encode([
                'promoName' => $product['promoName'],
                'promoRate' => $product['promoRate']
            ]);
        
            // Prepare the SQL query to insert each product into orders_item
            $insertQuery = "INSERT INTO orders_item (item_order_id, item_product_id, item_size, item_qty, item_product_price, promo_discount, item_total) 
                            VALUES ('$orderId', '$itemProductId', '$itemSize', '$itemQty', '$originalPrice', '$itemDiscountDetails', '$itemTotalPrice')";
            
            $user_id = $_SESSION['user_id'];
            
            $response = $db->RemoveItem($user_id, $itemProductId, $itemSize);
            
            // Execute the query for each product
            if (!$db->conn->query($insertQuery)) {
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
     