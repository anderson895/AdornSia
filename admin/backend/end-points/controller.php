<?php
include('../class.php');

$db = new global_class();


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
                    $uniqueFileName, 
                    $product_Stocks
                );
        
                if ($prod_id) {
                    if (!empty($product_Sizes)) {
                     
                        foreach ($product_Sizes as $size) {
                            $size = trim($size); 
                            if (!empty($size)) {
                                $db->addProductSize($prod_id, $size); 
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
        
        $product_Category = empty($_POST['product_Category_update']) ? NULL : $_POST['product_Category_update'];
        $product_Description = $_POST['product_Description_update'];
        $product_Promo = empty($_POST['product_Promo_update']) ? NULL : $_POST['product_Promo_update'];
        
        $product_Image = $_FILES['product_Image_update'];
        
        $existingImageName = $db->getProductImageById($product_id_update); 
        
        if ($product_Image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../../upload/';
        
            if ($existingImageName && file_exists($uploadDir . $existingImageName)) {
                unlink($uploadDir . $existingImageName);  
            }
        
            $fileExtension = pathinfo($product_Image['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('product_', true) . '.' . $fileExtension;
        
            $uploadFilePath = $uploadDir . $newFileName;
        
            if (move_uploaded_file($product_Image['tmp_name'], $uploadFilePath)) {
                $user = $db->updateProduct(
                    $product_id_update,
                    $product_Code,
                    $product_Name,
                    $product_Price,
                    $critical_Level,
                    $product_Category,
                    $product_Description,
                    $product_Promo,
                    $newFileName 
                );
        
                if ($user === 'success') {
                    echo 200; 
                } else {
                    echo 'Failed to update product in the database.';
                }
            } else {
                echo 'Error uploading image. Please try again.';
            }
        } else {
            $user = $db->updateProduct(
                $product_id_update,
                $product_Code,
                $product_Name,
                $product_Price,
                $critical_Level,
                $product_Category,
                $product_Description,
                $product_Promo,
                $existingImageName  
            );
        
            if ($user === 'success') {
                echo 200;  
            } else {
                echo 'Failed to update product in the database.';
            }
        }
        
        

        
    }else if($_POST['requestType'] =='StockIn'){
        $prod_name = $_POST['prod_name'];
        $stockin_qty = $_POST['stockin_qty'];
        $product_id_stockin = $_POST['product_id_stockin'];

        $user = $db->updateStock(
            $stockin_qty,
            $product_id_stockin,
            $prod_name
        );

        if ($user === 'success') {
            echo 200;
        } else {
            echo 'Failed to update product in the database.';
        }
    }else if($_POST['requestType'] =='UpdateOrderStatus'){

        $orderId = $_POST['orderId'];
$orderStatus = $_POST['orderStatus'];

if ($orderStatus === "Canceled") {
    // Cancel the order
    $order = $db->updateOrderStatus($orderId, $orderStatus);

    if ($order) {
        echo 200; 
    } else {
        echo 'Failed to update order in the database.';
    }
} elseif ($orderStatus === "Accept") {
    // Check stock sufficiency for the order
    $insufficientStockProducts = $db->validateStockSufficiency($orderId);

    if ($insufficientStockProducts === true) {
        // Proceed with updating the order status and deducting stock
        $order = $db->updateOrderStatus($orderId, $orderStatus);

        if ($order) {
            $stockout = $db->stockout($orderId);

            if ($stockout === true) {
                echo '200';
            } else {
                echo 'Failed to update stock in the database: ' . $stockout;  // Displaying detailed error if stockout fails
            }
        } else {
            echo 'Failed to update order status in the database.';
        }
    } else {
        // Handle insufficient stock scenario
        echo 'Insufficient stock for the following products: ' . implode(", ", $insufficientStockProducts);
    }
} else {
    
        // Proceed to update order status
        $order = $db->updateOrderStatus($orderId, $orderStatus);

        if ($order) {
            echo 200;  // Success
        } else {
            echo 'Failed to update order in the database.';
        }
   
}

        

        
        
    }else if($_POST['requestType'] =='RefundProduct'){

      
        $ref_id=$_POST['ref_id'];
        $new_status=$_POST['new_status'];

        $order = $db->updateRefundStatus($ref_id, $new_status);

        if ($order=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }


    }else if($_POST['requestType'] =='updatePromo'){

      
        $promo_id=$_POST['promo_id'];
        $promo_name=$_POST['promo_name'];
        $promo_description=$_POST['promo_description'];
        $promo_rate=$_POST['promo_rate'];
        $promo_expiration=$_POST['promo_expiration'];

        $order = $db->updatePromo($promo_id, $promo_name,$promo_description,$promo_rate,$promo_expiration);

        if ($order=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }
    }else if($_POST['requestType'] =='RemovePromo'){

      
        $promo_id=$_POST['promo_id'];

        $order = $db->updatePromoStatus($promo_id);

        if ($order=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }


    }else if($_POST['requestType'] =='addPromo'){

      
        $promo_name=$_POST['promo_name'];
        $promo_description=$_POST['promo_description'];
        $promo_rate=$_POST['promo_rate'];
        $promo_expiration=$_POST['promo_expiration'];

        $order = $db->addPromo($promo_name,$promo_description,$promo_rate,$promo_expiration);

        if ($order=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }

    }else if($_POST['requestType'] =='Adduser'){

      
        $admin_fullname=$_POST['admin_fullname'];
        $admin_username=$_POST['admin_username'];
        $admin_password=$_POST['admin_password'];

        $result = $db->Adduser($admin_fullname,$admin_username,$admin_password);

        if ($result=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }
    }else if($_POST['requestType'] =='Updateuser'){
        $update_admin_id=$_POST['update_admin_id'];
        $update_admin_fullname=$_POST['update_admin_fullname'];
        $update_admin_username=$_POST['update_admin_username'];
        $update_admin_password=$_POST['update_admin_password'];

        $result = $db->Updateuser($update_admin_id,$update_admin_fullname,$update_admin_username,$update_admin_password);

        if ($result=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }
    }else if($_POST['requestType'] =='DeleteUser'){
        $remove_admin_id=$_POST['remove_admin_id'];

        $result = $db->DeleteUser($remove_admin_id);

        if ($result=="success") {
            echo 200; 
        } else {
            echo 'Failed to update order in the database.';
        }
    }else{
        echo 'Invalid request type.';
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
        if ($_GET['requestType'] == 'GetAllOrders') {
            $orders = $db->GetAllOrders();
            if ($orders !== false) {
                echo json_encode(['status' => 'success', 'data' => $orders]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No cars found or error retrieving data.']);
            }
        }
}
?>
