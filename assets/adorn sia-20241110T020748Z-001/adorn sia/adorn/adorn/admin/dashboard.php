<?php include "../server.php"; ?>

<!DOCTYPE html>
  <!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">
<head>
    <title>Dashboard - Adorn</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Adornadmin.css">
    
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <nav class="sidebar close">
    <header>
            <div class="image-text">
                <span class="image">
                    <img src="images/logo2.png" alt="Adorn" class="logo"> <!-- Logo image -->
                </span>
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

                    <li class="nav-link active">
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
            
    </nav>
    <section class="home">
        <div class="text">Dashboard</div>
    </section>

    <script src="admin.js"></script>
</body>
</html>