<?php
session_start();

$link=new mysqli("localhost", "root", "", "adorn");
if(!$link) {
    die(mysqli_error($link));
}

$connection=mysqli_connect("localhost", "root", "","adorn");
/*$link=mysqli_connect("localhost", "root", "") or die (mysqli_error($link));
mysqli_select_db($link,"adorn") or die (mysqli_error($link));*/

$errorMessage = '';
$showForm = true;
$formSubmitted = false;
$userInput = '';

/****************************/
/*       sign up page       */
/****************************/

if (isset($_POST["signup"])) {
    //Generate unique filename
    $unik = md5(time());

    // Handle Front Image Upload
    $frontFileName = $_FILES["front_id"]["name"];
    $frontFileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $frontFileName);
    $frontDst = "./verify/{$unik}{$frontFileName}";
    $frontDst1 = "verify/{$unik}{$frontFileName}";
    
    // Handle Back Image Upload
    $backFileName = $_FILES["back_id"]["name"];
    $backDst = "./verify/{$unik}{$backFileName}";
    $backDst1 = "verify/{$unik}{$backFileName}";

    // Initialize the error message variable
    $errorMessage = '';
    $currentDateTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $currentDate = $currentDateTime->format('Y-m-d H:i:s'); 
    $firstname = ucfirst($_POST["firstname"]);
    $middle = ucfirst($_POST["middle"]);
    $lastname = ucfirst($_POST["lastname"]);
    $status = "pending";

    // Check if passwords match
    if ($_POST["password"] !== $_POST["confirm"]) {
        $errorMessage = 'Passwords do not match. Please try again.';
    } else if (move_uploaded_file($_FILES["front_id"]["tmp_name"],$frontDst) && move_uploaded_file($_FILES["back_id"]["tmp_name"],$backDst)) {
        // Check if username already exists
        $stmt = $link->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = 'Username already exists. Please choose a different one.';
        } else {
            // Calculate age from birthday
            $birthday = new DateTime($_POST["birthday"]);
            $today = new DateTime();
            $age = $today->diff($birthday)->y;

            // Check if the user is 18 years or older
            if ($age < 18) {
                $errorMessage = 'You must be at least 18 years old to register.';
            } else {
                // Prepare the insert query
                $stmt = $link->prepare("INSERT INTO users (datecreated, firstname, middle, lastname, username, birthday, age, email, phone, password, id_type, id_number, front_id, back_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    "sssssssssssssss",
                    $currentDate,
                    $firstname,
                    $middle,
                    $lastname,
                    $_POST['username'],
                    $_POST['birthday'],
                    $age,
                    $_POST['email'],
                    $_POST['phone'],
                    $_POST['password'],
                    $_POST['idType'], 
                    $_POST['idNumber'], 
                    $frontDst1,
                    $backDst1,
                    $status
                );

                if ($stmt->execute()) {
                    $_SESSION['username'] = $_POST["username"];

                    header('location: login.php');
                    exit();
                } else {
                    $errorMessage = 'Failed to register. Please try again.';
                }
            }
        }
    }
}


/***************************/
/*       user module       */
/***************************/

if (isset($_POST['login'])) {
    $formSubmitted = true; 
    $user = $_POST['user'];
    $password = $_POST['pw'];

    // Repopulated after a failed attempt
    $userInput = htmlspecialchars($user);

    // Check if the username exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Check if the password matches
        if ($password == $row['password']) {
            // Check status 
            if ($row['status'] == 'approved') {
                $_SESSION['username'] = $user;
                header('Location: index.php');
                exit();
            } elseif ($row['status'] == 'pending') {
                $errorMessage = "Account not yet approved.";
            }
        } else {
            $errorMessage = "Incorrect password.";
        }
    } else {
        $errorMessage = "Username not found.";
    }
}

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location: index.php');
    exit();
}


/****************************/
/*       admin module       */
/****************************/

if (isset($_POST['admin-login'])) {
    $formSubmitted = true; 
    $user = $_POST['adminUser'];
    $password = $_POST['adminPass'];
    $currentDateTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $currentDate = $currentDateTime->format('Y-m-d H:i:s');

    // Repopulated after a failed attempt
    $userInput = htmlspecialchars($user);

    // Check if the username exists
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Check if the password matches
        if ($password == $row['password']) {  
            // Set session username
            $_SESSION['admin'] = $user;

            // Retrieve the admin ID
            $adminId = $row['id'];

            // Capture IP address and browser information
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $browserInfo = $_SERVER['HTTP_USER_AGENT'];

            // Insert login attempt into the login table with IP and browser info
            $loginQuery = "INSERT INTO login (id, time, ip_address, browser_info) VALUES (?, ?, ?, ?)";
            $loginStmt = mysqli_prepare($link, $loginQuery);
            mysqli_stmt_bind_param($loginStmt, "isss", $adminId, $currentDate, $ipAddress, $browserInfo);
            mysqli_stmt_execute($loginStmt);

            // Redirect to dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            $errorMessage = "Incorrect password.";
        }
    } else {
        $errorMessage = "Username not found.";
    }
}



if (isset($_POST['admin-logout'])){
    session_destroy();
    unset($_SESSION['admin']);
    header('location: login.php');
    exit();
}

if (isset($_POST['verify'])) {
    $user_id = $_POST['user_id'];
    $update_query = "UPDATE users SET status = 'approved' WHERE id = ?";
    $update_stmt = $link->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);    
    $update_stmt->execute();
    $update_stmt->close();
}

if (isset($_POST['decline'])) {
    $user_id = $_POST['user_id']; 
    $update_query = "DELETE FROM users WHERE id = ?";
    $update_stmt = $link->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);    
    $update_stmt->execute();
    header("Location: users.php");
    $update_stmt->close();
}

if (isset($_POST['add_category'])) { 
    $category_name = mysqli_real_escape_string($link, $_POST['category_name']);
    $query = "INSERT INTO product_category (product_category_name) VALUES ('$category_name')";

    if (mysqli_query($link, $query)) {
        echo "Category added successfully!";
        header("Location: inventory.php"); 
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }
}

if (isset($_GET['delete_category_id'])) {
    $category_id = $_GET['delete_category_id'];

    // Remove the products under the category being deleted
    $update_query = "DELETE FROM products WHERE product_category_name = '$category_id'";

    if (mysqli_query($link, $update_query)) {
        $delete_query = "DELETE FROM product_category WHERE product_category_id = '$category_id'";
        // Delete category
        if (mysqli_query($link, $delete_query)) {
            header("Location: inventory.php"); 
            exit();
        } else {
            echo "Error deleting category: " . mysqli_error($link);
        }
    } else {
        echo "Error updating products: " . mysqli_error($link);
    }
}


if (isset($_POST['add_product'])) { 
    $tm = md5(time());
    $fnm = $_FILES["product_image"]["name"];
    $fnm = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fnm);
    $dst = "../products/{$tm}{$fnm}";
    $dst1 = "products/{$tm}{$fnm}";

    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $dst)) {
        $product_name = mysqli_real_escape_string($link, $_POST['product_name']);
        $product_category_id = mysqli_real_escape_string($link, $_POST['product_category_name']);
        $product_price = mysqli_real_escape_string($link, $_POST['product_price']);

        $insert_query = "INSERT INTO products (product_image, product_name, product_category_name, product_price) 
                         VALUES ('$dst1', '$product_name', '$product_category_id', '$product_price')";

        if (mysqli_query($link, $insert_query)) {
            echo "Product added successfully!";
            $category_id = $_POST['category_id']; 
            header("Location: inventory.php?category_id=$category_id");
            exit();
        } else {
            echo "Error: " . mysqli_error($link);
        }
    } else {
        echo "File upload error: " . $_FILES["product_image"]["error"];
    }
}

// Fetch categories from the database
$query = "SELECT product_category_id, product_category_name FROM product_category";
$result = mysqli_query($link, $query);
$categories = [];

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Fetch products for the selected category
$products = [];
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $product_query = "SELECT p.product_id, p.product_image, p.product_name, p.product_price, c.product_category_name 
                      FROM products p 
                      JOIN product_category c ON p.product_category_name = c.product_category_id 
                      WHERE c.product_category_id = '$category_id'";

    $product_result = mysqli_query($link, $product_query);
    while ($product = mysqli_fetch_assoc($product_result)) {
        $products[] = $product;
    }
}


/****************************/
/*       staff module       */
/****************************/