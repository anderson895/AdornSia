<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function getCartlist($userID)
    {
        // Directly insert the userID into the query (no prepared statements)
        $query = "SELECT cart.*, product.*, promo.*, GROUP_CONCAT(sizes.size_id) AS sizes,
        CASE 
                    WHEN promo.promo_expiration < NOW() THEN NULL
                    ELSE product.prod_promo_id
                END AS prod_promo_id
            FROM `cart`
            LEFT JOIN product ON cart.cart_prod_id = product.prod_id
            LEFT JOIN promo ON promo.promo_id = product.prod_promo_id
            LEFT JOIN product_sizes AS sizes ON sizes.size_prod_id = product.prod_id
            WHERE cart.cart_user_id = '$userID'
            GROUP BY cart.cart_id, product.prod_id;
            ";
    
        $result = $this->conn->query($query);
        
        if ($result) {
            // Fetch all results and store in array
            $cartItems = [];
            while ($row = $result->fetch_assoc()) {
                $cartItems[] = $row;
            }
    
            // Return the result
            return $cartItems;
        }
    }


    public function fetch_product_info($product_id){
        $query = $this->conn->prepare("SELECT 
                product.*, 
                category.*, 
                promo.*, 
                CASE 
                    WHEN promo.promo_expiration < NOW() THEN NULL
                    ELSE product.prod_promo_id
                END AS prod_promo_id
            FROM product
            LEFT JOIN category
                ON product.prod_category_id = category.category_id
            LEFT JOIN promo
                ON promo.promo_id = product.prod_promo_id
        where prod_id ='$product_id'
        "    
    );

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    


    public function RemoveItem($user_id,$cart_id,$size)
    { 
        
        
            $updateStatusQuery = "DELETE FROM `cart` WHERE cart_user_id = $user_id AND cart_prod_id=$cart_id AND cart_prod_size='$size'";
            if ($this->conn->query($updateStatusQuery)) {
                return 200;
            }
    }


    public function getPaymentQr($cart_id)
    { 
        session_start();
        $user_id = $_SESSION['user_id'];
        
            $updateStatusQuery = "DELETE FROM `cart` WHERE cart_user_id = $user_id AND cart_prod_id=$cart_id";
            if ($this->conn->query($updateStatusQuery)) {
                return 200;
            }
    }


   
    
    



    public function UpdateAddress($address_id)
    { 
        session_start();
        $user_id = $_SESSION['user_id'];
    
        // Update all previous addresses to '0'
        $resetStatusQuery = "UPDATE `address_user` SET `ad_status` = '0' WHERE `ad_user_id` = '$user_id'";
        if ($this->conn->query($resetStatusQuery)) {
            // Update the current address to '1'
            $updateStatusQuery = "UPDATE `address_user` SET `ad_status` = '1' WHERE ad_id='$address_id' AND `ad_user_id` = '$user_id'";
            if ($this->conn->query($updateStatusQuery)) {
                return 200;
            }
        }
        return 400;
    }
    

    
    public function AddAddress($street_name, $barangay, $complete_address_add)
{
    session_start();
    $user_id = $_SESSION['user_id'];

    // Check if the address already exists
    $checkQuery = "SELECT * FROM `address_user` WHERE `ad_user_id` = '$user_id' AND `ad_address_code` = '$barangay' AND `ad_complete_address` = '$complete_address_add'";
    $result = $this->conn->query($checkQuery);

    if ($result->num_rows > 0) {
        return 409; // Address already exists
    } else {
        // Set all ad_status to 0 for this user
        $resetStatusQuery = "UPDATE `address_user` SET `ad_status` = '0' WHERE `ad_user_id` = '$user_id'";
        $this->conn->query($resetStatusQuery);

        // Insert new address with ad_status set to 1
        $query = "INSERT INTO `address_user` (`ad_user_id`, `ad_address_code`, `ad_complete_address`, `ad_status`) 
                  VALUES ('$user_id', '$barangay', '$complete_address_add', '1')";

        if ($this->conn->query($query)) {
            return 200; // Success
        } else {
            return 400; // Error
        }
    }
}

// Function to handle order creation
public function OrderRequest($address, $paymentMethod, $proofOfPayment, $fileName, $subtotal, $vat,$sf, $total)
{
    session_start();

    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s'); // Current timestamp
    $status = 'Pending'; // Default status

    // Sanitize each input
    $user_id = $this->conn->real_escape_string($user_id);
    $paymentMethod = $this->conn->real_escape_string($paymentMethod);
    $subtotal = $this->conn->real_escape_string($subtotal);
    $vat = $this->conn->real_escape_string($vat);
    $total = $this->conn->real_escape_string($total);
    $address = $this->conn->real_escape_string($address);

    $uniqueOrderCode = strtoupper(substr(uniqid(), -8)); 

    // If proofOfPayment is empty, set it to NULL for the database
    $proofOfPayment = (empty($proofOfPayment)) ? NULL : $proofOfPayment;

    // Prepare the SQL query with placeholders
    $query = "INSERT INTO `orders` 
                (`order_code`, `order_user_id`, `mode_of_payment`, `proof_of_payment`, `subtotal`, `vat`,`sf`, `total`, `delivery_address`, `order_date`, `order_status`) 
              VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?)";

    // Prepare the statement
    if ($stmt = $this->conn->prepare($query)) {

        // Bind parameters (s = string, d = double, i = integer)
        $stmt->bind_param('ssssddddsss', 
            $uniqueOrderCode, 
            $user_id, 
            $paymentMethod, 
            $proofOfPayment, 
            $subtotal, 
            $vat,
            $sf,
            $total, 
            $address, 
            $order_date, 
            $status
        );

        // Execute the query
        if ($stmt->execute()) {
            // Return the order ID upon success
            return ['status' => 'success', 'order_id' => $this->conn->insert_id];
        } else {
            return ['status' => 'error', 'message' => 'Failed to create order: ' . $this->conn->error];
        }

    } else {
        return ['status' => 'error', 'message' => 'Failed to prepare statement: ' . $this->conn->error];
    }
}






    public function RefundProduct($userId, $productId, $RefundReason)
    {
        $dateToday = date('Y-m-d H:i:s');
        $query = $this->conn->prepare("INSERT INTO `refund` (`ref_prod_id`, `ref_user_id`, `ref_reason`, `ref_date`) VALUES (?, ?, ?, ?)");
        $query->bind_param('iiss', $productId, $userId, $RefundReason, $dateToday);
        if ($query->execute()) {
            return true; 
        } else {
            return false; 
        }
    }




    public function getUserActiveAddress()
    {
        $user_id = $_SESSION['user_id'];

        $query = $this->conn->prepare("SELECT * FROM `address_user` WHERE `ad_user_id` = '$user_id'");
            if ($query->execute()) {
                $result = $query->get_result();
                return $result;
            }
        
    }
    public function getAllEwallet()
    {

        $query = $this->conn->prepare("SELECT * FROM ewallet where e_wallet_status='1'");
            if ($query->execute()) {
                $result = $query->get_result();
                return $result;
            }
        
    }

    public function fetch_order($userID){
        $query = $this->conn->prepare("SELECT * FROM orders WHERE orders.order_user_id = '$userID' ORDER BY order_date DESC");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    



    public function fetch_user_profile_image($userID) {
        // Prepare the query to fetch the profile image
        $query = $this->conn->prepare("SELECT `Profile_images` FROM `user` WHERE `user_id` = ?");
        
        // Bind the parameter
        $query->bind_param("i", $userID);
        
        // Execute the query
        $query->execute();
        
        // Fetch the result
        $result = $query->get_result();
        
        if ($result && $result->num_rows > 0) {
            // Fetch the profile image path
            $row = $result->fetch_assoc();
            return $row['Profile_images']; // Return the profile image path
        } else {
            return null; // Return null if no record is found
        }
    }

  


    public function update_user_info($userID, $fullname, $email, $phone, $profileImage) {
        // Start building the query
        $queryStr = "UPDATE `user` SET `Fullname` = ?, `Email` = ?, `Phone` = ?";
    
        // Add profile image conditionally to the query
        if (!empty($profileImage)) {
            $queryStr .= ", `Profile_images` = ?";
        }
    
        $queryStr .= " WHERE `user_id` = ?";
    
        // Prepare the query
        $query = $this->conn->prepare($queryStr);
    
        // Bind parameters based on the condition for profile image
        if (!empty($profileImage)) {
            $query->bind_param("ssssi", $fullname, $email, $phone, $profileImage, $userID);
        } else {
            $query->bind_param("sssi", $fullname, $email, $phone, $userID);
        }
    
        // Execute the query and return the result
        if ($query->execute()) {
            return true; // Return true on success
        } else {
            return false; // Return false on failure
        }
    }
    


    public function update_user_password($userID, $user_NewPassword, $user_CurrentPassword) {
        // Step 1: Verify if the current password matches the stored password
        $query = "
            SELECT `Password` 
            FROM `user` 
            WHERE `user_id` = ?
        ";
        
        // Prepare the query
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $userID); // Bind userID as integer
            $stmt->execute();
            $stmt->store_result();
            
            // Check if user exists and fetch the password
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($storedPassword);
                $stmt->fetch();
                
                // Verify current password (no hashing here, just plain text match)
                if ($user_CurrentPassword !== $storedPassword) {
                    $stmt->close();
                    return [
                        'success' => false,
                        'message' => 'Incorrect current password.'
                    ];
                }
            } else {
                $stmt->close();
                return [
                    'success' => false,
                    'message' => 'User not found.'
                ];
            }
    
            // Step 2: Update the password (without hashing)
            $updateQuery = "
                UPDATE `user` 
                SET `Password` = ? 
                WHERE `user_id` = ?
            ";
            
            // Prepare the update statement
            if ($updateStmt = $this->conn->prepare($updateQuery)) {
                $updateStmt->bind_param("si", $user_NewPassword, $userID);
                
                if ($updateStmt->execute()) {
                    $updateStmt->close();
                    $stmt->close();
                    return [
                        'success' => true,
                        'message' => 'Password updated successfully.'
                    ];
                } else {
                    $updateStmt->close();
                    $stmt->close();
                    return [
                        'success' => false,
                        'message' => 'Failed to update password.'
                    ];
                }
            } else {
                $stmt->close();
                return [
                    'success' => false,
                    'message' => 'SQL error while updating password.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'SQL error while verifying password.'
            ];
        }
    }
    
    
    
    
    
    
    

    

    public function fetch_user_info($userID){
        $query = $this->conn->prepare("SELECT * FROM user where user_id = '$userID'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    
    
    public function fetch_order_item($userID,$order_id){
        $query = $this->conn->prepare("SELECT * FROM orders
        LEFT JOIN orders_item
        ON orders.order_id = orders_item.item_order_id
        LEFT JOIN product
        ON product.prod_id = orders_item.item_product_id
        LEFT JOIN category
        ON category.category_id = product.prod_category_id
        LEFT JOIN refund
        ON refund.ref_prod_id = product.prod_id
        where orders.order_user_id = '$userID' AND orders_item.item_order_id ='$order_id'
        ");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    

    public function getOrderStatusCounts($userID)
    {
    
        $query = $this->conn->prepare(" SELECT COUNT(*) AS cartCount FROM `cart` where cart_user_id='$userID'");
    
        if ($query->execute()) {
            $result = $query->get_result()->fetch_assoc();
            // Return the result as JSON
            echo json_encode($result);
            return;
        }
    }

    // cart
    public function checkProductInCart($userId, $productId,$prodSize)
    {
        $query = $this->conn->prepare("SELECT * FROM `cart` WHERE `cart_prod_id` = '$productId' AND `cart_user_id` = '$userId' AND cart_prod_size='$prodSize'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function AddToCart($userId, $productId, $prodSize)
{
    // Step 1: Get current stock for the product
    $stockQuery = $this->conn->prepare("SELECT `product_stocks` FROM `product` WHERE `prod_id` = ?");
    $stockQuery->bind_param("i", $productId);
    $stockQuery->execute();
    $stockResult = $stockQuery->get_result();
    $product = $stockResult->fetch_assoc();
    
    // If no product is found, return an error (optional)
    if (!$product) {
        return 404; // Product not found
    }

    $availableStock = $product['product_stocks'];

    // Step 2: Check if the product is already in the cart
    $checkProductInCart = $this->checkProductInCart($userId, $productId, $prodSize);
    
    // If product is already in the cart
    if ($checkProductInCart->num_rows > 0) {
        // Get the current quantity in the cart
        $cartProduct = $checkProductInCart->fetch_assoc();
        $currentCartQty = $cartProduct['cart_Qty'];

        // If adding 1 more exceeds available stock, reject the addition
        if ($currentCartQty + 1 > $availableStock) {
            return 'Notenoughstock';
        }

        // Update the quantity in the cart
        $query = $this->conn->prepare("UPDATE `cart` SET `cart_Qty` = `cart_Qty` + 1 WHERE `cart_user_id` = ? AND `cart_prod_id` = ? AND `cart_prod_size` = ?");
        $query->bind_param("iii", $userId, $productId, $prodSize);
        $response = 'CartUpdated!';
    } else {
        // If the product is not in the cart, check if there's enough stock to add it
        if (1 > $availableStock) {  // 1 is the default quantity being added
            return 'Notenoughstock';
        }

        // Insert the product into the cart
        $query = $this->conn->prepare("INSERT INTO `cart` (`cart_prod_id`, `cart_Qty`, `cart_user_id`, `cart_prod_size`) VALUES (?, 1, ?, ?)");
        $query->bind_param("iii", $productId, $userId, $prodSize);
        $response = 'Added To Cart!';
    }

    // Execute the query and return response
    if ($query->execute()) {
        return $response;
    } else {
        return 400; // Error executing the query
    }
}




    


        public function MinusToCart($userId, $productId, $prodSize)
    {
        $checkProductInCart = $this->checkProductInCart($userId, $productId, $prodSize);

        if ($checkProductInCart->num_rows > 0) {
            $cartItem = $checkProductInCart->fetch_assoc();
            $newQty = $cartItem['cart_Qty'] - 1;  // Subtract 1 from the quantity

            if ($newQty <= 0) {
                // If the quantity is 0 or less, remove the product from the cart
                $query = "DELETE FROM `cart` WHERE `cart_user_id` = '$userId' AND `cart_prod_id` = '$productId' AND `cart_prod_size` = '$prodSize'";
                $response = 'Product Removed from Cart!';
            } else {
                // Update the quantity if it's still greater than 0
                $query = "UPDATE `cart` SET `cart_Qty` = '$newQty' WHERE `cart_user_id` = '$userId' AND `cart_prod_id` = '$productId' AND `cart_prod_size` = '$prodSize'";
                $response = 'Cart Updated!';
            }
        } else {
            $response = 'Product not found in cart!';
        }

        if ($this->conn->query($query)) {
            return $response;
        } else {
            return 400;
        }
    }

    
    public function getAllProductSize($prod_id) {
        $query = "SELECT * FROM product_sizes WHERE size_prod_id  = '$prod_id'"; // Direct query, no bind_param
        return $this->conn->query($query);
    }
    



   


    public function fetch_all_product() {
        $query = $this->conn->prepare("
            SELECT 
                product.*, 
                category.*, 
                promo.*, 
                CASE 
                    WHEN promo.promo_expiration < NOW() THEN NULL
                    ELSE product.prod_promo_id
                END AS prod_promo_id
            FROM product
            LEFT JOIN category
                ON product.prod_category_id = category.category_id
            LEFT JOIN promo
                ON promo.promo_id = product.prod_promo_id
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    


    public function fetch_all_categories(){
        $query = $this->conn->prepare("SELECT * 
        FROM category where status='1'"    
    );

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    
    

    
    
     

}
