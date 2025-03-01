<?php
include ('db.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function fetch_all_product() {
        $query = $this->conn->prepare("
            SELECT 
                product.*, 
                category.*, 
                promo.*, 
                CASE 
                    WHEN promo.promo_expiration < NOW() THEN NULL
                    WHEN promo.promo_status = '0' THEN NULL
                    ELSE product.prod_promo_id
                END AS prod_promo_id
            FROM product
            LEFT JOIN category
                ON product.prod_category_id = category.category_id
            LEFT JOIN promo
                ON promo.promo_id = product.prod_promo_id
            where prod_status='1'   
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

    public function verify_account($userId) {
        // Calculate the time 5 minutes ago from now
        $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        
        // Prepare the query to get user information including fullname and link expiration
        $query = "SELECT `Fullname`, `link_expiration` FROM `user` WHERE `user_id` = $userId";
        
        session_start();
    
        // Execute the query to get the user details
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $linkExpiration = $row['link_expiration'];
            
            // Store the Fullname in session
            $_SESSION['Fullname'] = $row['Fullname'];
            $_SESSION['user_id'] = $userId;
    
            // Check if the link has already expired
            if (strtotime($linkExpiration) < strtotime($fiveMinutesAgo)) {
                return "Link has expired";  // Link is expired
            } else {
                // Update the status if the link is still valid
                $updateQuery = "UPDATE `user` SET `status` = '1', `verificationKey` = null WHERE `user_id` = $userId";
                if ($this->conn->query($updateQuery)) {
                    return true;  // Successfully updated
                }
            }
        }
    
        return false;  // In case of any errors or no user found
    }
    
    

    

    public function update_verificationKey($userId)
{
    $link_expiration = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Generate a random verification key
    $randomVerification = bin2hex(random_bytes(16)); // Adjust the length as needed

    // Create the SQL query with direct variable insertion
    $query = "UPDATE `user` SET `verificationKey` = '$randomVerification', `link_expiration` = '$link_expiration' WHERE `user_id` = $userId";

    // Execute the query
    if ($this->conn->query($query)) {
        return $randomVerification;  // Return the generated verification key
    } else {
        return false;  // Return false if the query fails
    }
}

    
    
public function Login($email, $password)
{
    // Hash the input password using SHA-256
    $hashedPassword = hash('sha256', $password);

    // Prepare the SQL query
    $query = $this->conn->prepare("SELECT * FROM `user` WHERE `Email` = ? AND `Password` = ? AND status = '1'");

    // Bind the email and the hashed password
    $query->bind_param("ss", $email, $hashedPassword);
    
    // Execute the query
    if ($query->execute()) {
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Start the session and store user info
            session_start();
            $_SESSION['Fullname'] = $user['Fullname'];
            $_SESSION['user_id'] = $user['user_id'];

            return $user;  // Return user data
        } else {
            return false;  // User not found or incorrect credentials
        }
    } else {
        return false;  // Query failed to execute
    }
}







public function GenerateNewPassword($userId)
{
    // Validate and sanitize the user ID
    $userId = intval($userId); // Ensure user ID is an integer

    // Generate a random password (or token)
    $randomVerification = bin2hex(random_bytes(15)); // Adjust the length as needed

    // Hash the random password using SHA-256
    $hashedPassword = hash('sha256', $randomVerification);

    // Escape the hashed password string to prevent injection (not strictly necessary here since it's hashed)
    $escapedPassword = $this->conn->real_escape_string($hashedPassword);

    // Create the SQL query with sanitized inputs
    $query = "UPDATE `user` SET `Password` = '$escapedPassword' WHERE `user_id` = $userId";

    // Execute the query
    if ($this->conn->query($query)) {
        return $randomVerification; // Return the generated verification key (plain text for the user)
    } else {
        return false; // Return false if the query fails
    }
}







    public function CheckEmail($email)
    {
        $link_expiration = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    
        // Check if the email already exists
        $stmt = $this->conn->prepare("SELECT `user_id`, `Fullname`, `Email` FROM `user` WHERE `Email` = ? and status='1'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Email already exists, fetch the user data
            $userData = $result->fetch_assoc();
            
            $response = array(
                'status' => 'EmailExist',
                'message' => 'Email already exists',
                'data' => array(
                    'id' => $userData['user_id'],
                    'fullname' => $userData['Fullname'],
                    'email' => $userData['Email']
                )
            );
    
            echo json_encode($response);
            return;
        } else {
            // Email does not exist
            echo json_encode(array(
                'status' => 'EmailNotExists',
                'message' => 'The Email you entered is not connected to our system'
            ));
            return;
        }
    }
    








    public function SignUp($name, $email, $phone, $password)
{
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
    
    // Hash the password using SHA-256
    $hashedPassword = hash('sha256', $password);

    // Proceed with insertion if email does not exist
    $stmt = $this->conn->prepare("INSERT INTO `user` (`Fullname`, `Email`, `Phone`, `Password`, `link_expiration`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $hashedPassword, $link_expiration);

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




    
    public function getExpirationLink($userID)
    {
        $query = $this->conn->query("SELECT link_expiration FROM user WHERE user_id = $userID");
    
        if ($query) {
            $result = $query->fetch_assoc();
            return $result['link_expiration'] ?? null; // Return expiration date or null if not found
        }
        return false; // Return false if query execution failed
    }


    public function getVerificationKey($userID)
{
    // Ensure the date format for the expiration is valid and compare it with the current date
    $currentDate = date('Y-m-d H:i:s'); // Get the current date and time
    
    // Query to check if the verification link has not expired
    $query = $this->conn->query("SELECT verificationKey, link_expiration 
                                 FROM user 
                                 WHERE user_id = $userID");
    
    if ($query) {
        $result = $query->fetch_assoc();
        
        // If a result is found
        if ($result) {
            $isExpired = ($result['link_expiration'] <= $currentDate) ? true : false;
            
            // Return the JSON response
            return json_encode([
                'isExpired' => $isExpired,
                'verification_link' => $isExpired ? null : $result['verificationKey']
            ]);
        } else {
            return json_encode(['isExpired' => true, 'verification_link' => null]);
        }
    }
    
    return json_encode(['isExpired' => true, 'verification_link' => null]); // Return as expired if query fails
}

    

    
     

}
