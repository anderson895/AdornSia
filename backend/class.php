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

    public function SignUp($name, $email, $phone, $password)
    {
        // Set the timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');
    
        // Get the current time and add 5 minutes to it
        $link_expiration = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    
        // Prepare the SQL statement using prepared statements
        $stmt = $this->conn->prepare("INSERT INTO `user` (`Fullname`, `Email`, `Phone`, `Password`, `link_expiration`) VALUES (?, ?, ?, ?, ?)");
    
        // Bind parameters (we need 5 parameters here)
        $stmt->bind_param("sssss", $name, $email, $phone, $password, $link_expiration);
    
        // Execute the statement
        if ($stmt->execute()) {
            // Start the session
            session_start();
    
            // Get the last inserted ID
            $userId = $this->conn->insert_id;
    
            // Store the user ID in the session
            $_SESSION['id'] = $userId;
    
            // Prepare the response data
            $response = array(
                'status' => 'success',
                'id' => $userId
            );
    
            // Return the response as a JSON object
            echo json_encode($response);
        } else {
            // Return an error status with the error code
            echo json_encode(array('status' => 'error', 'message' => 'Unable to register'));
        }
    }
    

    
    
     

}
