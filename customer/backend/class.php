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
public function OrderRequest($address, $paymentMethod, $proofOfPayment, $fileName, $subtotal, $vat, $total)
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
                (`order_code`, `order_user_id`, `mode_of_payment`, `proof_of_payment`, `subtotal`, `vat`, `total`, `delivery_address`, `order_date`, `status`) 
              VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $this->conn->prepare($query)) {

        // Bind parameters (s = string, d = double, i = integer)
        $stmt->bind_param('ssssdddsss', 
            $uniqueOrderCode, 
            $user_id, 
            $paymentMethod, 
            $proofOfPayment, 
            $subtotal, 
            $vat, 
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
        $checkProductInCart = $this->checkProductInCart($userId, $productId, $prodSize);
        
        if ($checkProductInCart->num_rows > 0) {
            // Update the quantity if the product already exists in the cart
            $query = $this->conn->prepare("UPDATE `cart` SET `cart_Qty` = `cart_Qty` + 1 WHERE `cart_user_id` = '$userId' AND `cart_prod_id` = '$productId' AND `cart_prod_size` = '$prodSize'");
            $response = 'Cart Updated!';
        } else {
            // Insert the product into the cart if it does not exist
            $query = $this->conn->prepare("INSERT INTO `cart` (`cart_prod_id`, `cart_Qty`, `cart_user_id`, `cart_prod_size`) VALUES ('$productId', 1, '$userId', '$prodSize')");
            $response = 'Added To Cart!';
        }

        if ($query->execute()) {
            return $response;
        } else {
            return 400;
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
