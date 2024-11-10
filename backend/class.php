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

    public function verify_account($userId) {
        // Calculate the time 5 minutes ago from now
        $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    
        // Prepare the query to check if the link expiration is within 5 minutes from the current time
        $query = $this->conn->prepare("SELECT `link_expiration` FROM `user` WHERE `user_id` = ?");
        $query->bind_param("i", $userId);
    
        // Execute the query to get the expiration time
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $linkExpiration = $row['link_expiration'];
    
                // Check if the link has already expired
                if (strtotime($linkExpiration) < strtotime($fiveMinutesAgo)) {
                    return "Link has expired";  // Link is expired
                } else {
                    // Update the status if the link is still valid
                    $updateQuery = $this->conn->prepare("UPDATE `user` 
                                                         SET `status` = '1' 
                                                         WHERE `user_id` = ?");
                    $updateQuery->bind_param("i", $userId);
                    if ($updateQuery->execute()) {
                        return true;  // Successfully updated
                    }
                }
            }
        }
        return false;  // In case of any errors or no user found
    }

    

    public function update_verificationKey($userId)
    {
        // Generate a random verification key
        $randomVerification = bin2hex(random_bytes(16)); // You can adjust the length as needed
    
        // Prepare the SQL query
        $query = $this->conn->prepare("UPDATE `user` SET `verificationKey` = ? WHERE `user_id` = ?");
        
        // Bind parameters
        $query->bind_param("si", $randomVerification, $userId);
        
        // Execute the query and check if successful
        if ($query->execute()) {
            return $randomVerification;  // Return the generated verification key
        } else {
            return false;  // Return false if the query fails
        }
    }
    
    
    public function Login($email, $password)
    {
        $query = $this->conn->prepare("SELECT * FROM `user` WHERE `Email` = ? AND `Password` = ? AND status = '1'");

        $query->bind_param("ss", $email, $password);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                session_start();
                $_SESSION['Fullname'] = $user['Fullname'];
                $_SESSION['user_id'] = $user['user_id'];

                return $user;
            } else {
                return false; 
            }
        } else {
            return false;
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
