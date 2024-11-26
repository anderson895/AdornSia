<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');
$getDateToday = date('Y-m-d H:i:s'); 


class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }





    
    public function getDataAnalytics()
    {
        // Query to get user count, orders count, and total sales for delivered orders
        $query = " 
            SELECT 
                (SELECT COUNT(*) FROM `user`) AS userCount,
                (SELECT COUNT(*) FROM `orders` where order_status='Delivered') AS pendingOrders,
                (SELECT SUM(`total`) FROM `orders` WHERE `order_status` = 'Delivered') AS totalSales
        ";
    
        // Execute the query
        $result = $this->conn->query($query);
        
        if ($result) {
            // Fetch the result and return as JSON
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            // Error handling if query fails
            echo json_encode(['error' => 'Failed to retrieve counts']);
        }
    }


    public function getMonthlySalesData()
    {
        $query = "
            SELECT 
                MONTH(`order_date`) AS `order_month`,
                SUM(`total`) AS `monthly_sales`
            FROM `orders`
            WHERE `order_status` = 'Delivered' 
            AND YEAR(`order_date`) = YEAR(CURDATE()) 
            GROUP BY MONTH(`order_date`) 
            ORDER BY `order_month`
        ";
    
        $result = $this->conn->query($query);
    
        if ($result) {
            $salesData = [];
            while ($row = $result->fetch_assoc()) {
                $salesData[] = [
                    'month' => date('F', mktime(0, 0, 0, $row['order_month'], 10)),
                    'sales' => $row['monthly_sales']
                ];
            }
            echo json_encode($salesData);
        } else {
            // Log the error for debugging
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve monthly sales data']);
        }
    }
    
    public function top5bestSelling()
    {
        $query = "
           SELECT 
                orders_item.item_product_id, 
                product.*,
                SUM(orders_item.item_qty) AS total_quantity_sold
            FROM 
                orders_item
            LEFT JOIN 
                product ON orders_item.item_product_id = product.prod_id
            GROUP BY 
                orders_item.item_product_id
            ORDER BY 
                total_quantity_sold DESC
            LIMIT 5
        ";
        
        $result = $this->conn->query($query);
        
        if ($result) {
            $topProducts = [];
            while ($row = $result->fetch_assoc()) {
                $topProducts[] = $row;
            }
            return $topProducts;
        } else {
            // Log the error for debugging
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve data']);
        }
    }
    



    public function SalesReport()
    {
        // SQL query to get total revenue and quantity sold
        $query = "
            SELECT 
                p.prod_name AS product,   -- Assuming 'prod_name' is the product name field
                o.order_date,
                SUM(oi.item_total) AS total_revenue, 
                SUM(oi.item_qty) AS total_quantity_sold
            FROM orders_item oi
            JOIN orders o ON oi.item_order_id = o.order_id
            LEFT JOIN product p ON oi.item_product_id = p.prod_id
            WHERE o.order_status = 'Delivered'
            GROUP BY p.prod_id, o.order_date
        ";
    
        // Execute the query
        $result = $this->conn->query($query);
    
        if ($result) {
            // Fetch all the rows and return them as an array
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Log the error for debugging
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve data']);
            return [];  // Return an empty array in case of error
        }
    }

    public function getSalesReport($reportType, $startYear = null, $endYear = null)
    {
        // Determine the date range based on the report type
        $dateFilter = '';
        switch ($reportType) {
            case 'daily':
                $dateFilter = "DATE(o.order_date) = CURDATE()"; // Filter for today's date
                break;
            case 'weekly':
                $dateFilter = "YEARWEEK(o.order_date, 1) = YEARWEEK(CURDATE(), 1)"; // Filter for this week
                break;
            case 'monthly':
                $dateFilter = "MONTH(o.order_date) = MONTH(CURDATE()) AND YEAR(o.order_date) = YEAR(CURDATE())"; // Filter for this month
                break;
            case 'yearly':
                if ($startYear && $endYear) {
                    $dateFilter = "YEAR(o.order_date) BETWEEN $startYear AND $endYear"; // Filter by custom year range
                } else {
                    $dateFilter = "YEAR(o.order_date) = YEAR(CURDATE())"; // Default to the current year
                }
                break;
            default:
                $dateFilter = '1'; // No filter (default to all records)
                break;
        }
    
        // SQL query to get total revenue and quantity sold, with the date filter
        $query = "
            SELECT 
                p.prod_name AS product, 
                o.order_date,
                SUM(oi.item_total) AS total_revenue, 
                SUM(oi.item_qty) AS total_quantity_sold
            FROM orders_item oi
            JOIN orders o ON oi.item_order_id = o.order_id
            LEFT JOIN product p ON oi.item_product_id = p.prod_id
            WHERE o.order_status = 'Delivered' AND $dateFilter
            GROUP BY p.prod_id, o.order_date
        ";
    
        // Execute the query
        $result = $this->conn->query($query);
    
        if ($result) {
            // Fetch all the rows and return them as an array
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Log the error for debugging
            error_log('Database query failed: ' . $this->conn->error);
            return []; // Return an empty array in case of error
        }
    }
    
    




    public function top5Customer()
{
    // SQL query to get the top 5 customers by total amount spent
    $query = "
        SELECT user.*, 
            orders.order_user_id, 
            SUM(orders.total) AS total_spent, 
            COUNT(orders.order_id) AS total_orders
        FROM orders
        LEFT JOIN user ON user.user_id = orders.order_user_id
        GROUP BY orders.order_user_id
        ORDER BY total_spent DESC
        LIMIT 5
    ";

    
    // Execute the query
    $result = $this->conn->query($query);
    
    if ($result) {
        $topCustomers = [];
        while ($row = $result->fetch_assoc()) {
            $topCustomers[] = $row;
        }
        return $topCustomers;
    } else {
        // Log the error for debugging
        error_log('Database query failed: ' . $this->conn->error);
        echo json_encode(['error' => 'Failed to retrieve data']);
    }
}

    

    public function StockLevel()
{
    // SQL query to get product details including the stock level
    $query = "SELECT * FROM product WHERE prod_status = 1  LIMIT 5"; // Ensuring only active products are considered
    
    $result = $this->conn->query($query);
    
    if ($result) {
        $productLevels = [];
        
        while ($row = $result->fetch_assoc()) {
            // Classify stock level based on product_stocks and prod_critical
            $stockStatus = '';

            if ($row['product_stocks'] <= 0) {
                $stockStatus = 'Out of Stock';
            } elseif ($row['product_stocks'] <= $row['prod_critical']) {
                $stockStatus = 'Critical';
            } else {
                $stockStatus = 'Normal';
            }

            // Add product data with stock level classification
            $productLevels[] = [
                'prod_id' => $row['prod_id'],
                'prod_name' => $row['prod_name'],
                'product_stocks' => $row['product_stocks'],
                'prod_critical' => $row['prod_critical'],
                'prod_image' => $row['prod_image'],
                'stock_status' => $stockStatus,
            ];
        }
        
        return $productLevels;
    } else {
        // Log the error for debugging
        error_log('Database query failed: ' . $this->conn->error);
        echo json_encode(['error' => 'Failed to retrieve data']);
    }
}




    public function topNewProduct()
    {
        // SQL query to get the latest products
        $query = "
            SELECT prod_id, prod_code, prod_name, prod_currprice, prod_image, prod_added 
            FROM product 
            WHERE prod_status = 1
            ORDER BY prod_added DESC
            LIMIT 5
        ";
        
        $result = $this->conn->query($query);
        
        if ($result) {
            $topProducts = [];
            while ($row = $result->fetch_assoc()) {
                $topProducts[] = $row;
            }
            return $topProducts;
        } else {
            // Log the error for debugging
            error_log('Database query failed: ' . $this->conn->error);
            echo json_encode(['error' => 'Failed to retrieve data']);
        }
    }
    
    
    
  public function getWeeklySalesData()
    {
        $query = "
            SELECT 
                WEEK(`order_date`, 1) AS `order_week`,  -- `1` means the week starts on Monday
                SUM(`total`) AS `weekly_sales`
            FROM `orders`
            WHERE `order_status` = 'Delivered' 
            AND YEAR(`order_date`) = YEAR(CURDATE())  -- Filter for current year
            GROUP BY WEEK(`order_date`, 1)
            ORDER BY `order_week`
        ";
    
        $result = $this->conn->query($query);
    
        if ($result) {
            $salesData = [];
            while ($row = $result->fetch_assoc()) {
                $salesData[] = [
                    'week' => 'Week ' . $row['order_week'],
                    'sales' => $row['weekly_sales']
                ];
            }
            echo json_encode($salesData); // Return the sales data as JSON
        } else {
            echo json_encode(['error' => 'Failed to retrieve weekly sales data']);
        }
    }



public function getDailySalesData()
{
    $query = "
        SELECT 
            DATE(`order_date`) AS `order_day`, 
            SUM(`total`) AS `daily_sales`
        FROM `orders`
        WHERE `order_status` = 'Delivered' 
        AND MONTH(`order_date`) = MONTH(CURDATE()) 
        AND YEAR(`order_date`) = YEAR(CURDATE())
        GROUP BY DATE(`order_date`)
        ORDER BY `order_day`
    ";

    $result = $this->conn->query($query);

    if ($result) {
        $salesData = [];
        while ($row = $result->fetch_assoc()) {
            $salesData[] = [
                'date' => $row['order_day'],
                'sales' => $row['daily_sales']
            ];
        }
        echo json_encode($salesData); // Return the sales data as JSON
    } else {
        echo json_encode(['error' => 'Failed to retrieve daily sales data']);
    }
}






    public function check_account($admin_id) {
        // I-sanitize ang admin_id para maiwasan ang SQL injection
        $admin_id = intval($admin_id);
    
        // SQL query para hanapin ang admin_id sa table
        $query = "SELECT * FROM admin WHERE admin_id = $admin_id";
    
        $result = $this->conn->query($query);
    
        // Prepare ang array para sa result
        $items = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items; // Ibabalik ang array ng results o empty array kung walang nahanap
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
        
        $getDateToday = date('Y-m-d H:i:s'); 
   
    
        $query = "INSERT INTO `product` 
                    (`prod_code`, `prod_name`, `prod_currprice`, `prod_category_id`, `prod_critical`, `prod_description`, `prod_promo_id`, `prod_image`, `prod_added`, `prod_status`, `product_stocks`) 
                  VALUES 
                    ('$product_Code', '$product_Name', '$product_Price', '$product_Category', '$critical_Level', '$product_Description', '$product_Promo', '$product_Image', '$getDateToday', '1', '$product_Stocks')";
    

    
                 //Start Activity Logs
                 session_start();
                 $admin_username=$_SESSION['admin_username'];
                 $getDateToday = date('Y-m-d H:i:s'); 
                 $logs = "INSERT INTO `activity_logs` (`log_name`, `log_role`, `log_date`, `log_activity`)  VALUES ('$admin_username', 'Administrator', '$getDateToday', 'Added $product_Name')";
                 $this->conn->query($logs);
                 //End Activity Logs
 
       
        // Execute the query
        if ($this->conn->query($query)) {
            $prod_id = $this->conn->insert_id; 
            return $prod_id; 
        } else {
            return false; 
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


    public function stockout($orderId) {
        // Step 1: Fetch order items
        $orderItemsQuery = "SELECT p.prod_name ,oi.item_product_id, oi.item_qty FROM orders_item as oi
        LEFT JOIN product as p
        ON p.prod_id = oi.item_product_id
        WHERE oi.item_order_id = $orderId";
        $orderItemsResult = mysqli_query($this->conn, $orderItemsQuery);
    
        if (!$orderItemsResult) {
            // Return error message if the query fails
            return 'Error fetching order items: ' . mysqli_error($this->conn);
        }
    
        // Step 2: Deduct stock for each item
        while ($item = mysqli_fetch_assoc($orderItemsResult)) {
            $productId = $item['item_product_id'];
            $itemQty = $item['item_qty'];
            $prod_name = $item['prod_name'];
    
            // Step 3: Check if sufficient stock is available
            $checkStockQuery = "SELECT product_stocks FROM product WHERE prod_id = $productId";
            $checkStockResult = mysqli_query($this->conn, $checkStockQuery);
    
            if (!$checkStockResult) {
                // Return error message if the stock query fails
                return 'Error checking stock for product ' . $productId . ': ' . mysqli_error($this->conn);
            }
    
            $stock = mysqli_fetch_assoc($checkStockResult);
    
            // If stock is sufficient, proceed with the update
            if ($stock && $stock['product_stocks'] >= $itemQty) {
                $updateStockQuery = "
                    UPDATE product
                    SET product_stocks = product_stocks - $itemQty
                    WHERE prod_id = $productId
                ";
    
                $updateStockResult = mysqli_query($this->conn, $updateStockQuery);

                 //Start Activity Logs
                session_start();
                $admin_username=$_SESSION['admin_username'];
                $getDateToday = date('Y-m-d H:i:s'); 
                $logs = "INSERT INTO `activity_logs` (`log_name`, `log_role`, `log_date`, `log_activity`)  VALUES ('$admin_username', 'Administrator', '$getDateToday', '$prod_name StockOut - $itemQty')";
                $this->conn->query($logs);
                //End Activity Logs

            } else {
                // Return message if there's not enough stock
                return 'Not enough stock for product ' . $productId;
            }
        }
    
        // Return success message if everything is successful
        return true;
    }
    
    
    
    
    
    
    public function validateStockSufficiency($orderId) {
        $insufficientStockProducts = [];
    
        $orderItemsQuery = "SELECT item_product_id, item_qty FROM orders_item WHERE item_order_id = '$orderId'";
        $orderItemsResult = mysqli_query($this->conn, $orderItemsQuery);
    
        if (!$orderItemsResult || mysqli_num_rows($orderItemsResult) === 0) {
            return false; // No items found
        }
    
        while ($item = mysqli_fetch_assoc($orderItemsResult)) {
            $productId = $item['item_product_id'];
            $itemQty = $item['item_qty'];
    
            $checkStockQuery = "SELECT prod_name, product_stocks FROM product WHERE prod_id = $productId";
            $stockResult = mysqli_query($this->conn, $checkStockQuery);
            $stock = mysqli_fetch_assoc($stockResult);
    
            if (!$stock || $stock['product_stocks'] < $itemQty) {
                // Add product to insufficient stock list
                $insufficientStockProducts[] = $stock['prod_name'] . " (ID: $productId)";
            }
        }
    
        // If there are any products with insufficient stock, return the list
        if (!empty($insufficientStockProducts)) {
            return $insufficientStockProducts;
        }
    
        return true; // All items have sufficient stock
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
        
        //Start Activity Logs
        session_start();
        $admin_username=$_SESSION['admin_username'];
        $logs = "INSERT INTO `activity_logs` (`log_name`, `log_role`, `log_date`, `log_activity`)  VALUES ('$admin_username', 'Administrator', '$getDateToday', 'Update $product_Name')";
        $this->conn->query($logs);
        //End Activity Logs
        // Execute the query
        if ($query->execute()) {
            return "success";
        } else {
            return false; 
        }

       

    }
    
    
    public function Login($username, $password)
{
    // Hash the password using SHA-256
    $hashed_password = hash('sha256', $password);

    // Prepare the SQL query to check the username and hashed password
    $query = $this->conn->prepare("SELECT * FROM `admin` WHERE `admin_username` = ? AND `admin_password` = ? AND admin_status='1'");
    $query->bind_param("ss", $username, $hashed_password);

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


    public function fetch_all_user(){
        $query = $this->conn->prepare("SELECT * FROM `admin` where admin_status='1'");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    

    public function fetch_all_promotion(){
        $query = $this->conn->prepare("SELECT * FROM `promo` where promo_status='1'");

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

    public function fetch_all_activity() {
        $query = $this->conn->prepare("SELECT * FROM `activity_logs` ORDER BY `log_id` DESC");
    
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
        ON product.prod_category_id = category.category_id
        where prod_status='1'
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }



    public function updateStock($stockin_qty, $product_id,$prod_name) {
        $query = $this->conn->prepare("UPDATE `product` SET `product_stocks` = `product_stocks` + ? WHERE `prod_id` = ?");
        $query->bind_param("ii", $stockin_qty, $product_id); 


          //Start Activity Logs
          session_start();
          $admin_username=$_SESSION['admin_username'];
          $getDateToday = date('Y-m-d H:i:s'); 
          $logs = "INSERT INTO `activity_logs` (`log_name`, `log_role`, `log_date`, `log_activity`)  VALUES ('$admin_username', 'Administrator', '$getDateToday', '$prod_name StockIn + $stockin_qty')";
          $this->conn->query($logs);
          //End Activity Logs

        if ($query->execute()) {
            return 'success'; 
        } else {
            return false;
        }
    }

    public function updateRefundStatus($ref_id, $new_status) {
        $query = $this->conn->prepare("UPDATE `refund` SET `ref_status` = ? WHERE `ref_id` = ?");
        $query->bind_param("si", $new_status, $ref_id); 
        if ($query->execute()) {
            return 'success'; 
        } else {
            return false;
        }
    }



    public function updatePromo($promo_id, $promo_name, $promo_description, $promo_rate, $promo_expiration) {
        $query = $this->conn->prepare(
            "UPDATE `promo` 
             SET `promo_name` = ?, 
                 `promo_description` = ?, 
                 `promo_rate` = ?, 
                 `promo_expiration` = ? 
             WHERE `promo_id` = ?"
        );
        
        // Bind parameters (s = string, i = integer, d = double)
        $query->bind_param("ssdsi", $promo_name, $promo_description, $promo_rate, $promo_expiration, $promo_id);
        
        // Execute the query and check for success
        if ($query->execute()) {
            return 'success';
        } else {
            return false;
        }
    }

    public function addPromo($promo_name, $promo_description, $promo_rate, $promo_expiration) {
        // Prepare the SQL query
        $query = $this->conn->prepare(
            "INSERT INTO `promo` (`promo_name`, `promo_description`, `promo_rate`, `promo_expiration`, `promo_status`) 
             VALUES (?, ?, ?, ?, 1)" // Assuming `promo_status` is defaulted to 1 for active promotions
        );
    
        // Check if the query was prepared successfully
        if (!$query) {
            return 'Error: ' . $this->conn->error;
        }
    
        // Bind parameters (s = string, d = double for rate)
        $query->bind_param("ssds", $promo_name, $promo_description, $promo_rate, $promo_expiration);
    

        

        // Execute the query and check for success
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }


    public function Adduser($admin_fullname, $admin_username, $admin_password) {
        // Hash the password using SHA-256
        $hashed_password = hash('sha256', $admin_password);
    
        // Prepare the SQL query
        $query = $this->conn->prepare(
            "INSERT INTO `admin` (`admin_username`, `admin_password`, `admin_fullname`) 
             VALUES (?, ?, ?)"
        );
    
        // Bind parameters (s = string)
        $query->bind_param("sss", $admin_username, $hashed_password, $admin_fullname);
    
        // Execute the query and check for success
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }
    


    public function Updateuser($update_admin_id, $update_admin_fullname, $update_admin_username, $update_admin_password) {
        // Hash the password using SHA-256
        $hashed_password = hash('sha256', $update_admin_password);
    
        // Prepare the SQL query directly
        $query = "UPDATE `admin` SET `admin_username`='$update_admin_username', `admin_password`='$hashed_password', `admin_fullname`='$update_admin_fullname' WHERE `admin_id`='$update_admin_id'";
    
        // Execute the query and check for success
        if ($this->conn->query($query)) {
            return 'success';
        } else {
            return 'Error: ' . $this->conn->error;
        }
    }
    

    public function DeleteUser($remove_admin_id) {
       
    
        // Prepare the SQL query directly
        $query = "UPDATE `admin` SET admin_status='0' WHERE `admin_id`='$remove_admin_id'";
    
        // Execute the query and check for success
        if ($this->conn->query($query)) {
            return 'success';
        } else {
            return 'Error: ' . $this->conn->error;
        }
    }
    

    public function updatePromoStatus($promo_id) {
       
            $query = "UPDATE `promo` 
                      SET `promo_status` = 0
                      WHERE `promo_id` = $promo_id";
    
            // Execute the query
            if ($this->conn->query($query)) {
                return 'success';
            } else {
                return 'Error: ' . $this->conn->error;
            }
    }
    
    public function updateProductStatus($prod_id) {
       
        $query = "UPDATE `product` 
                  SET `prod_status` = 0
                  WHERE `prod_id` = $prod_id";

        // Execute the query
        if ($this->conn->query($query)) {
            return 'success';
        } else {
            return 'Error: ' . $this->conn->error;
        }
}


    
    public function fetch_all_refund() {
        $sql = "SELECT * FROM refund
        LEFT JOIN orders_item
        ON orders_item.item_id = refund.ref_item_id 
        LEFT JOIN orders
        ON orders.order_id  = orders_item.item_order_id  
        LEFT JOIN product
        ON product.prod_id = orders_item.item_product_id  
        LEFT JOIN user
        ON user.user_id = orders.order_user_id   
        ";
        $result = $this->conn->query($sql);
    
        if ($result) {
            $refunds = [];
            while ($row = $result->fetch_assoc()) {
                $refunds[] = $row;
            }
            return $refunds; 
        } else {
            return false; 
        }
    }
    
    

            
    

    
    
     

}
