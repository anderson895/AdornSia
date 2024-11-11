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
