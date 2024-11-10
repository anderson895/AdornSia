<?php include "../server.php";

$id=$_GET["id"];
$datecreated="";
$firstname="";
$middle="";
$lastname="";
$username="";
$birthday="";
$age="";
$email="";
$phone="";
$idtype="";
$idno="";
$front="";
$back="";
$res=mysqli_query($link, "SELECT * FROM users where id=$id");
while($row=mysqli_fetch_array($res)) {
    $datecreated=$row["datecreated"];
    $firstname=$row["firstname"];
    $middle=$row["middle"];
    $lastname=$row["lastname"];
    $username=$row["username"];
    $birthday=$row["birthday"];
    $age=$row["age"];
    $email=$row["email"];
    $phone=$row["phone"];
    $idtype=$row["id_type"];
    $idno=$row["id_number"];
    $front=$row["front_id"];
    $back=$row["back_id"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Users - Adorn</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Adornadmin.css">
    <link rel="icon" type="image/x-icon" href="../images/nav_logo2.png">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="images/nav_logo2.png" alt="Adorn>
                </span>

                <div class="text logo-text">
                    <span class="name"><img src="images/nav_logo2.png" height="18px"></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="dashboard.php">
                            <i class='bx bxs-dashboard icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link active">
                        <a href="users.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">User Accounts</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="inventory.php">
                            <i class='bx bx-store-alt icon'></i>
                            <span class="text nav-text">Products</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="staff.php">
                            <i class='bx bxs-id-card icon'></i>
                            <span class="text nav-text">Staff</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="transactions.php">
                            <i class='bx bx-receipt icon'></i>
                            <span class="text nav-text">Transactions</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content" onclick="window.location.href='admin.php'">
                <li class="profile">
                    <?php if (isset($_SESSION['admin'])); ?>
                    <span class="mode-text text"><?php echo $_SESSION['admin']; ?></span>
                    <i class='bx bxs-chevron-right'></i>
                    <div class="container">
                            <img src="../images/profile.png" alt="profile">
                    </div>
                </li>                
            </div>
        </div>

    </nav>



    <section class="home">
        <div class="text">User Accounts</div>

        <div class="content">
            <ul class="breadcrumb">
                <li><a href="users.php">Users</a></li>
                <li><a href="viewuser.php?id= <?php echo $row["id"]; ?>"><?php echo $username; ?></a></li>
            </ul>
            <div>
                
                <?php 
                    $query = "SELECT * FROM users WHERE id = ?";
                    $stmt = $link->prepare($query);
                    $stmt->bind_param("i", $id); // Replace $user_id with the relevant ID variable
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        // Check if the status is 'pending'
                        if ($row['status'] == 'pending') {
                            // If pending, display only the pictures
                            ?>
                            <div class="verify-user">
                                <div class="info-column">
                                <h2>Personal Information</h2>
                                <strong>Name:</strong> <?php echo $firstname . " "; if (!empty($middle)) { echo $middle . ". "; } echo $lastname; ?><br>
                                <strong>Birthday:</strong> <?php echo $birthday; ?><br>
                                <strong>Age:</strong> <?php echo $age; ?><br>
                                <strong>ID Type:</strong> <?php echo $idtype; ?><br>
                                <strong>ID Number:</strong> <?php echo $idno; ?><br>
                                <form method="post" action="">
                                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="verify">Approve</button>
                                    <button type="submit" name="decline">Decline</button>
                                </form>
                                </div>
                                <div class="image-column">
                                    <label>Front</label>
                                    <img class="id" src="../<?php echo $front; ?>" alt="Front ID"><br>
                                    <label>Back</label>
                                    <img class="id" src="../<?php echo $back; ?>" alt="Back ID">                                
                                </div>                                
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="user-container">
                                <div class="profile-card">
                                    <img class="profile-image" src="../images/profile.png" alt="<?php echo $username . ' profile'; ?>">
                                    <h2 class="name"><?php echo $firstname . " "; if (!empty($middle)) { echo $middle . ". "; } echo $lastname; ?></h2>
                                    <p class="details">@<?php echo $username; ?></p>
                                    <p class="details">joined <?php echo $datecreated; ?></p>
                                </div>
                                <div class="info-card">
                                    <div class="personal-info">
                                        <h2>Personal Information</h2>
                                        <div class="info-row">
                                            <strong>Name</strong>
                                            <span><?php echo $firstname . " " . $middle . " " . $lastname; ?></span>
                                        </div>
                                        <div class="info-row">
                                            <strong>Birthday</strong>
                                            <span><?php echo $birthday; ?></span>
                                        </div>
                                        <div class="info-row">
                                            <strong>Age</strong>
                                            <span><?php echo $age; ?></span>
                                        </div>
                                    </div>

                                    <div class="contact-info">
                                        <h2>Contact Information</h2>
                                        <div class="info-row">
                                            <strong>Email</strong>
                                            <span><?php echo $email; ?></span>
                                        </div>
                                        <div class="info-row">
                                            <strong>Phone</strong>
                                            <span><?php echo $phone; ?></span>
                                        </div>
                                        <div class="info-row">
                                            <strong>Address</strong>
                                            <span><!-- Address data here --></span>
                                        </div>
                                    </div>

                                    <div class="orders-info">
                                        <h2>Orders</h2>
                                        <!-- Orders data here -->
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No data found.";
                    }
                    
                    $stmt->close();
                ?>
            </div>
        </div>
    </section>

    <script src="admin.js"></script>
</body>

</html>