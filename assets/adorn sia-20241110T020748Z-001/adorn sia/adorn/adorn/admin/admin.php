<?php 
include "../server.php"; 

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Fetch the admin information from the database
$username = $_SESSION['admin'];
$query = "SELECT * FROM admins WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$adminInfo = mysqli_fetch_assoc($result);

// Fetch the login history for the admin
$adminID = $adminInfo['id'];
$loginQuery = "SELECT * FROM login WHERE id = ? ORDER BY time DESC";
$loginStmt = mysqli_prepare($link, $loginQuery);
mysqli_stmt_bind_param($loginStmt, "i", $adminID);
mysqli_stmt_execute($loginStmt);
$loginResult = mysqli_stmt_get_result($loginStmt);
?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
    <title>Admin - Adorn</title>
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
                    <img src="../images/nav_logo2.png" alt="adorn">
                </span>

                <div class="text logo-text">
                    <span class="name"><img src="../images/nav_logo2.png" height="18px"></span>
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

                    <li class="nav-link">
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
            <div class="admin-profile">
                <h2>Admin Profile</h2>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($adminInfo['username']); ?></p>
                <p><strong>Password:</strong> <?php echo htmlspecialchars($adminInfo['password']); ?></p>
                
                <form action="admin.php" method="post">
                    <button type="submit" name="admin-logout">LOGOUT</button>
                </form>
            </div>

            <div class="login-history">                
                    <h3>Login History</h3>
                    <table id="admin-table">
                        <th>
                            <tr class="header">
                                <th style="width: 15%">Login Time</th>
                                <th style="width: 10%">IP Address</th>
                                <th style="width: 75%">Browser</th>
                            </tr>
                        </th>
                        <tbody id="admin-body">
                            <?php
                                while ($loginRow = mysqli_fetch_assoc($loginResult)) {
                                    echo "<tr>";
                                    echo "<td>";echo htmlspecialchars($loginRow['time']); echo "</td>";
                                    echo "<td>"; echo htmlspecialchars($loginRow['ip_address']); echo "</td>";
                                    echo "<td>"; echo htmlspecialchars($loginRow['browser_info']); echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </section>

        <script src="admin.js"></script>
</body>

</html>