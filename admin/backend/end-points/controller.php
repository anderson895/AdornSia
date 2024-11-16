<?php
include('../class.php');

$db = new global_class();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$product_Category = $product_Promo = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['requestType'] == 'AddProduct') {

        $product_Code = $_POST['product_Code'];
        $product_Name = $_POST['product_Name'];
        $product_Price = $_POST['product_Price'];
        $critical_Level = $_POST['critical_Level'];
        
        // Check if category and promo are empty, set them to NULL
        $product_Category = empty($_POST['product_Category']) ? NULL : $_POST['product_Category'];
        $product_Description = $_POST['product_Description'];
        $product_Promo = empty($_POST['product_Promo']) ? NULL : $_POST['product_Promo'];
        $product_Stocks = $_POST['product_Stocks'];
        
        // Handle the uploaded image
        $product_Image = $_FILES['product_Image'];
        
        // Capture sizes (it's an array)
        $product_Sizes = isset($_POST['product_Sizes']) ? $_POST['product_Sizes'] : [];
        
        // Check if the image was uploaded without errors
        if ($product_Image['error'] === UPLOAD_ERR_OK) {
            // Set the upload directory
            $uploadDir = '../../../upload/';
        
            // Get the file extension
            $fileExtension = pathinfo($product_Image['name'], PATHINFO_EXTENSION);
        
            // Generate a unique file name using uniqid() and append the file extension
            $uniqueFileName = uniqid('product_', true) . '.' . $fileExtension;
        
            // Set the full upload file path
            $uploadFilePath = $uploadDir . $uniqueFileName;
        
            // Move the uploaded image to the specified directory
            if (move_uploaded_file($product_Image['tmp_name'], $uploadFilePath)) {
                // Add the product and get the product ID
                $prod_id = $db->addProduct(
                    $product_Code,
                    $product_Name,
                    $product_Price,
                    $critical_Level,
                    $product_Category,
                    $product_Description,
                    $product_Promo,
                    $uniqueFileName, // Pass only the unique file name
                    $product_Stocks
                );
        
                // Check if the product was successfully added (prod_id will be returned on success)
                if ($prod_id) {
                    // Now handle sizes if they exist
                    if (!empty($product_Sizes)) {
                        // Insert each size into the database (assuming a 'product_sizes' table exists)
                        foreach ($product_Sizes as $size) {
                            $size = trim($size); // Remove any leading/trailing spaces
                            if (!empty($size)) {
                                // Add the size to the 'product_sizes' table using the product's ID
                                $db->addProductSize($prod_id, $size); // Use the prod_id here
                            }
                        }
                    }
        
                    echo 200; // Success response
                } else {
                    echo 'Failed to add product to the database.';
                }
            } else {
                echo 'Error uploading image. Please try again.';
            }
        } else {
            echo 'No image uploaded or there was an error with the image.';
        }
        

        
    } else if ($_POST['requestType'] == 'UpdateProduct') {
        
        $product_id_update = $_POST['product_id_update'];
        $product_Code = $_POST['product_Code_update'];
        $product_Name = $_POST['product_Name_update'];
        $product_Price = $_POST['product_Price_update'];
        $critical_Level = $_POST['critical_Level_update'];
        
        // Check if category and promo are empty, set them to NULL
        $product_Category = empty($_POST['product_Category_update']) ? NULL : $_POST['product_Category_update'];
        $product_Description = $_POST['product_Description_update'];
        $product_Promo = empty($_POST['product_Promo_update']) ? NULL : $_POST['product_Promo_update'];
        
        // Handle the uploaded image
        $product_Image = $_FILES['product_Image_update'];
        
        // Get the current image name from the database
        $existingImageName = $db->getProductImageById($product_id_update);  // Assuming this function exists in your database class
        
        // If an image is uploaded, handle it
        if ($product_Image['error'] === UPLOAD_ERR_OK) {
            // Set the upload directory
            $uploadDir = '../../../upload/';
        
            // Delete the existing image if it exists
            if ($existingImageName && file_exists($uploadDir . $existingImageName)) {
                unlink($uploadDir . $existingImageName);  // Delete the old image
            }
        
            // Get the file extension and generate a unique file name for the new image
            $fileExtension = pathinfo($product_Image['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('product_', true) . '.' . $fileExtension;
        
            // Set the full upload file path
            $uploadFilePath = $uploadDir . $newFileName;
        
            // Move the uploaded image to the specified directory
            if (move_uploaded_file($product_Image['tmp_name'], $uploadFilePath)) {
                // Image upload successful, now update the product in the database
                $user = $db->updateProduct(
                    $product_id_update,
                    $product_Code,
                    $product_Name,
                    $product_Price,
                    $critical_Level,
                    $product_Category,
                    $product_Description,
                    $product_Promo,
                    $newFileName  // Pass the new image file name
                );
        
                // Check if the product was successfully updated
                if ($user === 'success') {
                    echo 200;  // Success response
                } else {
                    echo 'Failed to update product in the database.';
                }
            } else {
                echo 'Error uploading image. Please try again.';
            }
        } else {
            // If no image was uploaded, update the product without changing the image
            $user = $db->updateProduct(
                $product_id_update,
                $product_Code,
                $product_Name,
                $product_Price,
                $critical_Level,
                $product_Category,
                $product_Description,
                $product_Promo,
                $existingImageName  // Retain the existing image file name
            );
        
            // Check if the product was successfully updated
            if ($user === 'success') {
                echo 200;  // Success response
            } else {
                echo 'Failed to update product in the database.';
            }
        }
        
        

        
    }else if($_POST['requestType'] =='StockIn'){

        $stockin_qty = $_POST['stockin_qty'];
        $product_id_stockin = $_POST['product_id_stockin'];

        $user = $db->updateStock(
            $stockin_qty,
            $product_id_stockin
        );

        // Check if the product was successfully updated
        if ($user === 'success') {
            echo 200;  // Success response
        } else {
            echo 'Failed to update product in the database.';
        }
    }else if($_POST['requestType'] =='UpdateOrderStatus'){

        $orderId = $_POST['orderId'];         // Get order ID
        $orderStatus = $_POST['orderStatus']; // Get the new order status
        
        // Assuming the method updateOrderStatus accepts $orderId and $orderStatus
        $order = $db->updateOrderStatus($orderId, $orderStatus);
        
        // Check if the product was successfully updated
        if ($order === 'success') {
            echo 200;  // Success response
        } else {
            echo 'Failed to update order in the database.';
        }
        
    }else{
        echo 'Invalid request type.';
    }
}if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
        if ($_GET['requestType'] == 'GetAllOrders') {
            // Fetch the cars from the database
            $orders = $db->GetAllOrders();
        
            // Check if cars data exists
            if ($orders !== false) {
                // Return the cars data as JSON
                echo json_encode(['status' => 'success', 'data' => $orders]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No cars found or error retrieving data.']);
            }
        }
}
?>
