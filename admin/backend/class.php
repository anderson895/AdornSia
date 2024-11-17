<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function fetch_item_orders($orderId) {
        $query = "
            SELECT * FROM orders_item 
            LEFT JOIN product
            ON product.prod_id = orders_item.item_product_id
            LEFT JOIN category
            ON category.category_id = product.prod_category_id
            LEFT JOIN orders
            ON orders.order_id = orders_item.item_order_id 
            WHERE item_order_id = '$orderId'
        ";
        $result = $this->conn->query($query);
        $items = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items;
    }
    


    public function addProduct(
        $product_Code,
        $product_Name,
        $product_Price,
        $critical_Level,
        $product_Category,
        $product_Description,
        $product_Promo,
        $product_Image,
        $product_Stocks
    ) {
        // Get today's date
        $getDateToday = date('Y-m-d H:i:s'); // Or use any other format as needed
        
        // Prepare the SQL query with placeholders for bound parameters
        $query = $this->conn->prepare("INSERT INTO `product` (`prod_code`, `prod_name`, `prod_currprice`, `prod_category_id`, `prod_critical`, `prod_description`, `prod_promo_id`, `prod_image`, `prod_added`, `prod_status`, `product_stocks`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, '1', ?)");
        
        // Bind the parameters
        $query->bind_param("ssssssssss", 
            $product_Code, 
            $product_Name, 
            $product_Price, 
            $product_Category, 
            $critical_Level, 
            $product_Description, 
            $product_Promo, 
            $product_Image, 
            $getDateToday, 
            $product_Stocks
        );
        
        // Execute the query
        if ($query->execute()) {
            // Get the product ID of the last inserted product
            $prod_id = $this->conn->insert_id; // Get the last inserted product ID
            return $prod_id; // Return the product ID to use in adding sizes
        } else {
            return false; // Return false if insertion fails
        }
    }
    

  


    public function addProductSize($prod_id, $size) {
        $stmt = $this->conn->prepare("INSERT INTO product_sizes (size_prod_id, size_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $prod_id, $size); // Use product ID and size
        return $stmt->execute();
    }

    public function updateOrderStatus($orderId,$newStatus) {
        $stmt = $this->conn->prepare("UPDATE `orders` SET `order_status` = '$newStatus' WHERE `orders`.`order_id` = '$orderId'");
        return $stmt->execute();
    }


    public function stockout($orderId, $newStatus) {
        // Start transaction
        mysqli_query($this->conn, "START TRANSACTION");
    
        try {
            // Step 1: Fetch order items
            $orderItemsQuery = "SELECT item_product_id, item_qty FROM orders_item WHERE item_order_id = '$orderId'";
            $orderItemsResult = mysqli_query($this->conn, $orderItemsQuery);
    
            if (!$orderItemsResult || mysqli_num_rows($orderItemsResult) === 0) {
                throw new Exception("No items found for order ID: $orderId.");
            }
    
            // Step 2: Deduct stock for each item
            while ($item = mysqli_fetch_assoc($orderItemsResult)) {
                $productId = $item['item_product_id'];
                $itemQty = $item['item_qty'];
    
                // Deduct stock with validation to prevent negative stocks
                $updateStockQuery = "
                    UPDATE product 
                    SET product_stocks = product_stocks - $itemQty 
                    WHERE prod_id = $productId AND product_stocks >= $itemQty
                ";
                $updateResult = mysqli_query($this->conn, $updateStockQuery);
    
                if (!$updateResult || mysqli_affected_rows($this->conn) === 0) {
                    throw new Exception("Insufficient stock for product ID: $productId.");
                }
            }
    
            // Step 3: Update order status
            $updateOrderStatusQuery = "UPDATE orders SET order_status = '$newStatus' WHERE order_id = '$orderId'";
            $updateOrderResult = mysqli_query($this->conn, $updateOrderStatusQuery);
    
            if (!$updateOrderResult || mysqli_affected_rows($this->conn) === 0) {
                throw new Exception("Failed to update order status for order ID: $orderId.");
            }
    
            // Commit transaction
            mysqli_query($this->conn, "COMMIT");
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_query($this->conn, "ROLLBACK");
            error_log("Stockout failed: " . $e->getMessage());
            return false;
        }
    }
    
    

    public function GetAllOrders()
    {
        // Prepare the query with sorting by order_date in descending order
        $query = "SELECT * FROM orders
                  LEFT JOIN user ON user.user_id = orders.order_user_id
                  ORDER BY orders.order_date DESC"; 
    
        $result = $this->conn->query($query);
        
        // Check if the query was successful
        if ($result === false) {
            // Log or handle the error
            error_log("Query execution failed: " . $this->conn->error);
            return false;
        }
    
        // Check if there are any results
        if ($result->num_rows > 0) {
            // Fetch the results and return them as an associative array
            $order = [];
            while ($row = $result->fetch_assoc()) {
                $order[] = $row;
            }
            return $order;
        } else {
            return false;
        }
    }
    
    



  


    public function updateProduct(
        $prod_id,
        $product_Code,
        $product_Name,
        $product_Price,
        $critical_Level,
        $product_Category,
        $product_Description,
        $product_Promo,
        $product_Image
    ) {
        $getDateToday = date('Y-m-d H:i:s');
    
        // Start building the SQL query
        $sql = "UPDATE `product` SET 
                    `prod_code` = ?, 
                    `prod_name` = ?, 
                    `prod_currprice` = ?, 
                    `prod_category_id` = ?, 
                    `prod_critical` = ?, 
                    `prod_description` = ?, 
                    `prod_promo_id` = ?, 
                    `prod_added` = ?";
        
        // Check if `product_Image` has a value; if so, include it in the query
        $params = [$product_Code, $product_Name, $product_Price, $product_Category, $critical_Level, $product_Description, $product_Promo, $getDateToday];
        $paramTypes = "ssssssss";
        
        if (!empty($product_Image)) {
            $sql .= ", `prod_image` = ?";
            $params[] = $product_Image;
            $paramTypes .= "s";
        }
        
        // Complete the SQL query with the WHERE clause
        $sql .= " WHERE `prod_id` = ?";
        $params[] = $prod_id;
        $paramTypes .= "i";
    
        // Prepare the SQL statement
        $query = $this->conn->prepare($sql);
    
        // Bind parameters dynamically
        $query->bind_param($paramTypes, ...$params);
    
        // Execute the query
        if ($query->execute()) {
            return "success";
        } else {
            return false; 
        }
    }
    
    
    public function Login($username, $password)
    {
        $query = $this->conn->prepare("SELECT * FROM `admin` WHERE `admin_username` = ? AND `admin_password` = ?");
        $query->bind_param("ss", $username, $password);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                session_start();
                $_SESSION['admin_username'] = $user['admin_username'];
                $_SESSION['admin_id'] = $user['admin_id'];

                return $user;
            } else {
                return false; 
            }
        } else {
            return false;
        }
    }

    public function fetch_all_customers(){
        $query = $this->conn->prepare("SELECT * FROM `user`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }


    public function fetch_all_category(){
        $query = $this->conn->prepare("SELECT * FROM `category`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    public function fetch_all_promo(){
        $query = $this->conn->prepare("SELECT * FROM `promo`");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }

    
    public function getProductImageById($product_id) {
        $sql = "SELECT prod_image FROM product WHERE prod_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);  
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['prod_image'] : null;
    }
    


    public function fetch_all_product(){
        $query = $this->conn->prepare("SELECT * 
        FROM `product` 
        LEFT JOIN category
        ON product.prod_category_id = category.category_id");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function updateStock($stockin_qty, $product_id) {
        $query = $this->conn->prepare("UPDATE `product` SET `product_stocks` = `product_stocks` + ? WHERE `prod_id` = ?");
        $query->bind_param("ii", $stockin_qty, $product_id); 
        if ($query->execute()) {
            return 'success'; 
        } else {
            return false;
        }
    }
    

            
    

    
    
     

}
