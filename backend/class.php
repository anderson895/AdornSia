<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function fetch_all_product(){
        $query = $this->conn->prepare("SELECT * 
        FROM `product` 
        LEFT JOIN category
        ON product.prod_category_id = category.category_id
        LEFT JOIN promo
        ON promo.promo_id  = product.prod_promo_id"    
    );

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
    public function SignUp($name, $email, $phone, $password)
    {
        date_default_timezone_set('Asia/Manila');
        $link_expiration = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        
        // Check if the email already exists
        $stmt = $this->conn->prepare("SELECT * FROM `user` WHERE `Email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Email already exists, return error response
            echo json_encode(array('status' => 'EmailAlreadyExists', 'message' => 'Email already exists'));
            return;  // Stop further execution
        }
        
        // Proceed with insertion if email does not exist
        $stmt = $this->conn->prepare("INSERT INTO `user` (`Fullname`, `Email`, `Phone`, `Password`, `link_expiration`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $password, $link_expiration);
    
        if ($stmt->execute()) {
            session_start();
            $userId = $this->conn->insert_id;
            $_SESSION['id'] = $userId;
            $response = array(
                'status' => 'success',
                'id' => $userId
            );
            echo json_encode($response);
        } else {
            // Return an error status with the error code
            echo json_encode(array('status' => 'error', 'message' => 'Unable to register'));
        }
    }
    
    

    
    
     

}
