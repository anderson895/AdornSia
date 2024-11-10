<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function getSystemMaintinance()
    {
        $query = $this->conn->prepare("SELECT * FROM `maintinance`");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getOrderStatusCounts($acc_id)
{


    $query = $this->conn->prepare("
       SELECT  
            COUNT(CASE WHEN `status` = 'Pending' THEN 1 END) AS Pending,
            COUNT(CASE WHEN `status` = 'Accepted' THEN 1 END) AS Accepted,
            COUNT(CASE WHEN `status` = 'Ready For Delivery' THEN 1 END) AS ReadyForDelivery,
            COUNT(CASE WHEN `status` = 'Shipped' THEN 1 END) AS Shipped,
            COUNT(CASE WHEN `status` = 'Rejected' THEN 1 END) AS Rejected,
            COUNT(CASE WHEN `status` = 'Cancelled' THEN 1 END) AS Cancelled,
            COUNT(CASE WHEN `status` = 'Delivered' THEN 1 END) AS Delivered
        FROM `new_tbl_orders` where cust_id=$acc_id ;

    ");

    if ($query->execute()) {
        $result = $query->get_result()->fetch_assoc();
        // Return the result as JSON
        echo json_encode($result);
        return;
    }
}



    public function updatePass($currpass, $newpass, $confpass,$acc_id) {

        if ($newpass !== $confpass) {
            return "NotMatch";
        }

        // Query to get the current hashed password from the database
        $sql = "SELECT acc_password FROM account WHERE acc_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $acc_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_pass = $row['acc_password'];

            // Verify if the current password matches the one in the database
            if ($currpass === $stored_pass) {
                // Current password is correct, so update to the new password
                $update_sql = "UPDATE account SET acc_password = ? WHERE acc_id = ?";
                $update_stmt = $this->conn->prepare($update_sql);
                $update_stmt->bind_param('si', $newpass, $acc_id);

                if ($update_stmt->execute()) {
                    return "updatePassSuccess";
                } else {
                    return "Error updating password: " . $this->conn->error;
                }
            } else {
                // Current password does not match
                return "currentPassErr";
            }
        } else {
            // User not found in the database
            return "Account not found";
        }

        // Close the statement and connection
        $stmt->close();
        $this->conn->close();
    }


    public function updateEmpImage($emp_image, $userId)
    {
        $query = $this->conn->prepare("UPDATE `account` SET `emp_image` = ? WHERE `acc_id` = ?");
        $query->bind_param('si', $emp_image, $userId);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmpImage($userId)
    {
        // Prepare the SQL statement to select the employee's image
        $query = $this->conn->prepare("SELECT `emp_image` FROM `account` WHERE `acc_id` = ? LIMIT 1");
        $query->bind_param('i', $userId);

        // Execute the statement
        $query->execute();

        // Store the result
        $result = $query->get_result();

        // Fetch the result
        if ($result->num_rows > 0) {
            // Fetch the employee image name
            $row = $result->fetch_assoc();
            return $row['emp_image']; // Return the image name
        } else {
            return null; // No image found
        }
    }


    public function checkUser($userId)
    {
        $query = $this->conn->prepare("SELECT * FROM `account` WHERE `acc_id` = '$userId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getAllProducts($search, $category)
    {
        if ($search != '') {
            // Get Using Search
            $query = $this->conn->prepare("SELECT * 
                                           FROM `product` 
                                           WHERE (`prod_name` LIKE '%$search%' OR `prod_description` LIKE '%$search%')
                                           AND `prod_status` = '0' 
                                           AND `prod_sell_onlline` = '1'");
        } elseif ($category != 'All') {
            //Get Using Category
            $query = $this->conn->prepare("SELECT * FROM `product` WHERE `prod_status` = '0' AND `prod_sell_onlline` = '1' AND `prod_category_id` = '$category'");
        } else {
            // Get All
            $query = $this->conn->prepare("SELECT * FROM `product` WHERE `prod_status` = '0' AND `prod_sell_onlline` = '1'");
        }

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function getAllMessages($acc_id)
    {
            $query = $this->conn->prepare("SELECT * 
                                           FROM `messages` as m
                                           LEFT JOIN account as acc
                                           ON acc.acc_id = m.mess_sender
                                           WHERE m.mess_sender = '$acc_id' OR m.mess_reciever = '$acc_id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getCategories()
    {
        $query = $this->conn->prepare("SELECT * FROM `category` WHERE `category_status` = '1'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getBestSellers()
    {
        $query = $this->conn->prepare("SELECT p.*, SUM(po.orders_prodQty) AS total_quantity_sold
                                       FROM `product` AS p 
                                       LEFT JOIN pos_orders AS po ON p.prod_id = po.orders_prod_id 
                                       WHERE p.prod_sell_onlline = 1
                                       AND p.prod_status = 0
                                       GROUP BY p.prod_id, p.prod_name
                                       HAVING total_quantity_sold > 0
                                       ORDER BY total_quantity_sold DESC 
                                       LIMIT 5");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function checkProductQty($productId)
    {
        // $query = $this->conn->prepare("SELECT SUM(s_amount) AS total_stock FROM `stocks` WHERE `s_prod_id` = '$productId' AND s_status='1'");
        // if ($query->execute()) {
        //     $result = $query->get_result();
        //     return $result;
        // }

        $query = $this->conn->prepare("
            SELECT SUM(s_amount) AS total_stock 
            FROM `stocks` 
            WHERE `s_prod_id` = '$productId' 
            AND `s_status` = '1' 
            AND (`s_expiration` = '0000-00-00' OR `s_expiration` > CURDATE())
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }

    }

    public function getNewProducts()
    {
        $query = $this->conn->prepare("SELECT * 
                               FROM `product` 
                               WHERE `prod_status` = '0' 
                               AND `prod_sell_onlline` = '1' 
                               AND `prod_added` >= DATE_SUB(NOW(), INTERVAL 3 WEEK)
                               ORDER BY `prod_added` DESC
                               LIMIT 5");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    // Cart
    public function checkProductInCart($userId, $productId)
    {
        $query = $this->conn->prepare("SELECT * FROM `new_cart` WHERE `prod_id` = '$productId' AND `user_id` = '$userId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function addToCart($userId, $productId)
    {
        $checkProducyInCart = $this->checkProductInCart($userId, $productId);
        if ($checkProducyInCart->num_rows > 0) {
            $query = $this->conn->prepare("UPDATE `new_cart` SET `qty`= `qty` + '1' WHERE `user_id` = '$userId'");
            $response = 'Cart Updated!';
        } else {
            $query = $this->conn->prepare("INSERT INTO `new_cart`(`prod_id`, `qty`, `user_id`) VALUES ('$productId','1','$userId')");
            $response = 'Added To Cart!';
        }

        if ($query->execute()) {
            return $response;
        } else {
            return 400;
        }
    }

    // sentMessage
public function sentMessage($sender_id, $sender_Messages, $fileName)
{
    $dateToday = date('Y-m-d H:i:s'); 

    // Use null if $sender_Messages is an empty string
    if ($sender_Messages === "") {
        $sender_Messages = null;
    }

    if ($fileName === "") {
        $fileName = null;
    }

    // Prepare the SQL statement using prepared statements
    $stmt = $this->conn->prepare("INSERT INTO `messages` (`mess_sender`, `mess_content`, `mess_date`, `mess_reciever`, `mess_img`) VALUES (?, ?, ?, 'Admin', ?)");
    
    // Bind parameters
    $stmt->bind_param("isss", $sender_id, $sender_Messages, $dateToday, $fileName);

    // Execute the statement
    if ($stmt->execute()) {
        return 'Message sent!';
    } else {
        return 400; // Error code
    }
}



    

    public function getCartItems($userId)
    {
        $query = $this->conn->prepare("SELECT nc.cart_id, nc.qty, p.* FROM `new_cart` AS nc JOIN `product` AS p ON nc.prod_id = p.prod_id WHERE nc.user_id = '$userId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getCartItemsPhotos($userId,$prod_id)
    {
        $query = $this->conn->prepare("SELECT np.id, np.PHOTOS_PROD_ID, np.PROD_PHOTOS, p.* 
        FROM `productphotos` AS np
        JOIN `product` AS p ON np.PHOTOS_PROD_ID = p.prod_id
        LEFT JOIN `new_cart` AS nc ON nc.prod_id = p.prod_id
        LEFT JOIN `account` AS acc ON acc.acc_id = nc.user_id
        WHERE nc.user_id = '$userId' && np.PHOTOS_PROD_ID='$prod_id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getCartQty($cartId)
    {
        $query = $this->conn->prepare("SELECT * FROM `new_cart` WHERE `cart_id` = '$cartId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function updateCart($cartId, $updateType)
    {
        $cartQty = 0;
        $getCartQty = $this->getCartQty($cartId);
        if ($getCartQty->num_rows > 0) {
            $cart = $getCartQty->fetch_assoc();
            $cartQty = $cart['qty'];
        }

        if ($updateType == 'inc') {
            $query = $this->conn->prepare("UPDATE `new_cart` SET `qty`= `qty` + '1'  WHERE `cart_id` = '$cartId'");
        } elseif ($updateType == 'desc') {
            if ($cartQty <= 1) {
                return 'Invalid Quantity!';
            }

            $query = $this->conn->prepare("UPDATE `new_cart` SET `qty`= `qty` - '1'  WHERE `cart_id` = '$cartId'");
        } else {
            $query = $this->conn->prepare("DELETE FROM `new_cart` WHERE `cart_id` = '$cartId'");
        }

        if ($query->execute()) {
            return 200;
        }
    }

    public function updateCartQty($cartId, $qty)
    {
        if ($qty < 1) {
            return 400;
        }

        $query = $this->conn->prepare("UPDATE `new_cart` SET `qty`= '$qty'  WHERE `cart_id` = '$cartId'");
        if ($query->execute()) {
            return 200;
        }
    }

    public function deleteAllItemsInCart($userId)
    {
        $query = $this->conn->prepare("DELETE FROM `new_cart` WHERE `user_id` = '$userId'");
        if ($query->execute()) {
            return 200;
        }
    }

    // Maintenance
    public function getMaintenance()
    {
        $query = $this->conn->prepare("SELECT * FROM `maintinance`");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    // Shipping Fee
    public function getUserShippingFee($userId)
    {
        $query = $this->conn->prepare("SELECT tblA.address_rate AS sf, tblA.address_cod AS codAvail FROM `account` AS a 
                                       JOIN `user_address` AS ua ON a.acc_code = ua.user_acc_code
                                       LEFT JOIN tbl_address AS tblA ON ua.user_address_code = tblA.address_code
                                       WHERE a.acc_id = '$userId' AND tblA.address_display_status = 1");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    // Get Payment Types
    public function getPaymentTypes()
    {
        $query = $this->conn->prepare("SELECT * FROM `mode_of_payment` WHERE `payment_status` = '0'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function checkId($tableName, $columnName, $id)
    {
        $query = $this->conn->prepare("SELECT * FROM `$tableName` WHERE `$columnName` = '$id'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    // Place Order
    public function placeOrderCOD($post)
    {
        $date = date('Y-m-d H:i:s');

        // Order Id
        $orderId = 'ORD-' . random_int(000000, 999999);
        $checkOrderId = $this->checkId('new_tbl_orders', 'order_id', $orderId);
        while ($checkOrderId->num_rows > 0) {
            $orderId = 'ORD-' . random_int(000000, 999999);
            $checkOrderId = $this->checkId('new_tbl_orders', 'order_id', $orderId);
        }

        // Get Tax Rate
        $getMaintenance = $this->getMaintenance();
        if ($getMaintenance->num_rows > 0) {
            $maintenance = $getMaintenance->fetch_assoc();
            $taxRate = $maintenance['system_tax']/100;
        }

        $userId = $_SESSION['acc_id'];
        $paymentType = $_POST['paymentType'];
        $orderItems = json_decode($_POST['items'], true);

        $subtotal = 0;
        $vat = 0;
        $sf = 0;
        $total = 0;

        // Get SF
        $getUserSF = $this->getUserShippingFee($userId);
        if ($getUserSF->num_rows > 0) {
            $shippingFee = $getUserSF->fetch_assoc();
            $sf = $shippingFee['sf'];
        }

        foreach ($orderItems as $item) {
            $productId = $item['productId'];
            $qty = $item['qty'];

            $productAmount = $item['productPrice'] * $qty;
            $itemVat = $productAmount * $taxRate;

            $subtotal += $productAmount;
            $vat += $itemVat;

            $insertValues[] = "('$orderId', '$productId', '$qty')";

            $deleteItemsInCart = $this->conn->prepare("DELETE FROM `new_cart` WHERE `prod_id` = '$productId' AND `user_id` = '$userId'");
            $deleteItemsInCart->execute();
        }

        // $total = $subtotal + $vat + $sf; original computation
         $total = $subtotal+ $sf;


        $insertItemQuery = "INSERT INTO `new_tbl_order_items` (`order_id`, `product_id`, `qty`) VALUES " . implode(", ", $insertValues);
        $insertItem = $this->conn->prepare($insertItemQuery);

        // start getRiderId
        $query = $this->conn->prepare("SELECT tbladd.address_rider as AssignRider,ua.user_complete_address AS address FROM `account` AS a 
                                        LEFT JOIN `user_address` AS ua 
                                        ON a.acc_code = ua.user_acc_code 
                                        LEFT JOIN `tbl_address` AS tbladd 
                                        ON tbladd.address_code = ua.user_address_code 
                                        WHERE a.acc_id = '$userId'");
       if ($query->execute()) {
        $result = $query->get_result();
    
        // Fetch the result (assuming you're expecting a single result)
        if ($row = $result->fetch_assoc()) {
           $AssignRider=  $row['AssignRider']; // Return the user's address
       
        } else {
            $AssignRider= null; // Return null if the query fails
        }
        // end getRiderId
        
        $query = $this->conn->prepare("INSERT INTO `new_tbl_orders`(`order_id`, `cust_id`, `payment_id`, `subtotal`, `vat`, `sf`,`rider_id`, `total`, `order_date`, `status`) VALUES ('$orderId', '$userId', 'COD', '$subtotal', '$vat', '$sf','$AssignRider', '$total', '$date', 'Pending')");

        if ($query->execute() && $insertItem->execute()) {

            return 200;
        } else {
            echo "Error inserting order or order items.";
        }
        }
    }

    public function placeOrderWithPOF($post, $file)
    {
        $date = date('Y-m-d H:i:s');

        // Order Id
        $orderId = 'ORD-' . random_int(000000, 999999);
        $checkOrderId = $this->checkId('new_tbl_orders', 'order_id', $orderId);
        while ($checkOrderId->num_rows > 0) {
            $orderId = 'ORD-' . random_int(000000, 999999);
            $checkOrderId = $this->checkId('new_tbl_orders', 'order_id', $orderId);
        }

        // Get Tax Rate
        $getMaintenance = $this->getMaintenance();
        if ($getMaintenance->num_rows > 0) {
            $maintenance = $getMaintenance->fetch_assoc();
            $taxRate = $maintenance['system_tax']/100;
        }

        $userId = $_SESSION['acc_id'];
        $paymentType = $_POST['paymentType'];
        $orderItems = json_decode($_POST['items'], true);

        $subtotal = 0;
        $vat = 0;
        $sf = 0;
        $total = 0;

        // Get SF
        $getUserSF = $this->getUserShippingFee($userId);
        if ($getUserSF->num_rows > 0) {
            $shippingFee = $getUserSF->fetch_assoc();
            $sf = $shippingFee['sf'];
        }

        foreach ($orderItems as $item) {
            $productId = $item['productId'];
            $qty = $item['qty'];

            $productAmount = $item['productPrice'] * $qty;
            $itemVat = $productAmount * $taxRate;

            $subtotal += $productAmount;
            $vat += $itemVat;

            $insertValues[] = "('$orderId', '$productId', '$qty')";

            $deleteItemsInCart = $this->conn->prepare("DELETE FROM `new_cart` WHERE `prod_id` = '$productId' AND `user_id` = '$userId'");
            $deleteItemsInCart->execute();
        }



        // start getRiderId
        $query = $this->conn->prepare("SELECT tbladd.address_rider as AssignRider,ua.user_complete_address AS address FROM `account` AS a 
                                        LEFT JOIN `user_address` AS ua 
                                        ON a.acc_code = ua.user_acc_code 
                                        LEFT JOIN `tbl_address` AS tbladd 
                                        ON tbladd.address_code = ua.user_address_code 
                                        WHERE a.acc_id = '$userId'");
       if ($query->execute()) {
        $result = $query->get_result();
    
        // Fetch the result (assuming you're expecting a single result)
        if ($row = $result->fetch_assoc()) {
           $AssignRider=  $row['AssignRider']; // Return the user's address
       
        } else {
            $AssignRider= null; // Return null if the query fails
        }
        }
        // end getRiderId

        // $total = $subtotal + $vat + $sf; Old computation
        $total = $subtotal+ $sf; 
        if (!empty($_FILES['proofOfPayment']['size'])) {
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $destinationDirectory = __DIR__ . "/proof-of-payment/";
            $newFileName = $orderId . '.' . $extension;
            $destination = $destinationDirectory . $newFileName;
            if (is_uploaded_file($file_tmp)) {
                if (move_uploaded_file($file_tmp, $destination)) {
                    $insertItemQuery = "INSERT INTO `new_tbl_order_items` (`order_id`, `product_id`, `qty`) VALUES " . implode(", ", $insertValues);
                    $insertItem = $this->conn->prepare($insertItemQuery);
                    $query = $this->conn->prepare("INSERT INTO `new_tbl_orders`(`order_id`, `cust_id`, `payment_id`, `pof`,`subtotal`, `vat`, `sf`,`rider_id`, `total`, `order_date`, `status`) VALUES ('$orderId', '$userId', '$paymentType', '$newFileName','$subtotal', '$vat', '$sf','$AssignRider', '$total', '$date', 'Pending')");

                    if ($query->execute() && $insertItem->execute()) {
                        return 200;
                    } else {
                        echo "Error inserting order or order items.";
                    }
                } else {
                    // return 'Uploading file unsuccessfull';
                    return $destination;
                }
            } else {
                return "Error: File upload failed or file not found.";
            }
        } else {
            return 'File is empty';
        }
    }


    // Orders

    public function getUserOrders($userId, $status)
    {
        $query = $this->conn->prepare("SELECT * FROM `new_tbl_orders`
        LEFT JOIN account ON account.acc_id = new_tbl_orders.rider_id
        WHERE `cust_id` = '$userId' AND `status` = '$status' 
        ORDER BY `new_tbl_orders`.`order_date` DESC");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getUserOrderItems($orderId)
    {
        $query = $this->conn->prepare("SELECT i.qty, p.* FROM `new_tbl_order_items` AS i JOIN `product` AS p ON i.product_id = p.prod_id WHERE i.order_id = '$orderId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function cancelOrder($orderId,$cancelReason)
    {
        $query = $this->conn->prepare("UPDATE `new_tbl_orders` SET `status`= 'Cancelled',`cancel_reason`='$cancelReason' WHERE `order_id` = '$orderId'");
        if ($query->execute()) {
            return 200;
        }
    }

    public function getUserAddress($userId)
    {
        $query = $this->conn->prepare("SELECT ua.user_complete_address AS address FROM `account` AS a 
                                        LEFT JOIN `user_address` AS ua ON a.acc_code = ua.user_acc_code WHERE a.acc_id = '$userId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function getUserAddress2($userId)
    {
        $query = $this->conn->prepare("SELECT * FROM `user_address` WHERE `user_acc_code` = '$userId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function editUser($post, $userId)
    {
        $query = $this->conn->prepare("UPDATE `account` SET `acc_username`=?, `acc_fname`=?, `acc_lname`=?, `acc_birthday`=?, `acc_email`=?, `acc_contact`=? WHERE `acc_id` = ?");

        $query->bind_param("ssssssi", $post['editUsername'], $post['editFName'], $post['editLName'], $post['editBday'], $post['editEmail'], $post['editContact'], $userId);

        if ($query->execute()) {
            return 200;
        } else {
            return "Error updating user: " . $query->error;
        }
    }

    public function checkUserAddress($accId)
    {
        $query = $this->conn->prepare("SELECT * FROM `user_address` WHERE `user_acc_code` = '$accId'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function updateAddress($post)
    {
        $accCode = $post["accCode"];

        $checkUserAddress = $this->checkUserAddress($accCode);

        if ($checkUserAddress->num_rows > 0) {
            // Update
            $query = $this->conn->prepare("UPDATE `user_address` SET `user_address_code`='" . $post['barangayCode'] . "',`user_complete_address`='" . $post['completeAddress'] . "' WHERE `user_acc_code` = '" . $post['accCode'] . "'");
            if ($query->execute()) {
                return 200;
            }
        } else {
            // Add
            $query = $this->conn->prepare("
                INSERT INTO `user_address` (
                    `user_acc_code`,
                    `user_address_fullname`,
                    `user_address_phone`,
                    `user_address_email`,
                    `user_address_code`,
                    `user_complete_address`,
                    `user_active_status`,
                    `user_add_display_status`,
                    `user_add_Default_status`
                ) VALUES (
                    '" . $post['accCode'] . "',
                    '" . $post['userFullName'] . "',
                    '" . $post['userPhone'] . "',
                    '" . $post['userEmail'] . "',
                    '" . $post['barangayCode'] . "',
                    '" . $post['completeAddress'] . "',
                    '1',
                    '1',
                    '1'
                )
            ");
            if ($query->execute()) {
                return 200;
            }
        }
    }






     // Rate
     public function rate($post, $userId)
     {
         // Use date with timezone
         $dateToday = new DateTime("now", new DateTimeZone('Asia/Manila'));
         $formattedDate = $dateToday->format('Y-m-d H:i:s');
     
         // Prepare and execute the insert query with parameterized statements
         $userIdParam = $userId;
         $smesIdParam = $post['id'];
         $rateParam = $post['star'];

         $tsReviewName=$post['tsReviewName'];
         $reviewParam = $post['review'] ?? ''; // Default to empty string if review is not set
     
         $query = $this->conn->prepare("INSERT INTO `rate_reviews` (`r_user_id`, `r_prod_id`, `r_rate`, `r_feedback`, `r_date_added`) VALUES (?, ?, ?, ?, ?)");
         $query->bind_param('sssss', $userIdParam, $smesIdParam, $rateParam, $reviewParam, $formattedDate);
     
         if ($query->execute()) {
             $activityDescription = "Gave " . $post['star'] . " Stars" . (!empty($post['review']) ? " and commented on $tsReviewName: " . $post['review'] : " on $smesIdParam");
     
             $query_activity_log = $this->conn->prepare("INSERT INTO `users_log` (`act_account_id`, `act_activity`, `act_date`, `act_table`, `act_collumn_id`, `act_seen`) VALUES (?, ?, ?, 'Feedback', ?, '0')");
             if (!$query_activity_log) {
                 die("Prepare failed: " . $this->conn->error);
             }
     
             $query_activity_log->bind_param('ssss', $userIdParam, $activityDescription, $formattedDate, $smesIdParam);
             if (!$query_activity_log->execute()) {
                 die("Execute failed: " . $query_activity_log->error);
             }
     
             return 200;
         }
     
         // Handle errors if needed
         return 500;
     }
     
     


     public function getAllReviewsInAccom($id)
     {
        
         $query = $this->conn->prepare("SELECT srr.r_date_added,srr.r_rate,srr.r_feedback,t.acc_username,t.emp_image
         FROM rate_reviews as srr
         LEFT JOIN account as t
         ON t.acc_id = srr.r_user_id 
         where srr.r_prod_id='$id' AND r_status ='1'
         ORDER BY srr.r_date_added DESC");
         if ($query->execute()) {
             $result = $query->get_result();
             return $result;
         }
     }



     public function getAverageRating($prod_id)
     {
         $sql = "SELECT AVG(r_rate) as avg_rating, COUNT(r_rate) as total_ratings FROM rate_reviews WHERE r_prod_id = ?";
         $stmt = $this->conn->prepare($sql);
         $stmt->bind_param("s", $prod_id);
         $stmt->execute();
         $result = $stmt->get_result();
 
         $response = [];
         if ($result->num_rows > 0) {
             $row = $result->fetch_assoc();
             $response['avg_rating'] = round($row['avg_rating'], 1);
             $response['total_ratings'] = $row['total_ratings'];
         } else {
             $response['avg_rating'] = 0;
             $response['total_ratings'] = 0;
         }
 
         $stmt->close();
         return $response;
     }



     

}
