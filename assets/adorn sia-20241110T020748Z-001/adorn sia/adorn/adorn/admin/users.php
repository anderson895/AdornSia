<?php include "../server.php" ?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
    <title>Users - Adorn</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Adornadmin.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="images/logo1.png" alt="Adorn">
                </span>

                <div class="text logo-text">
                    <span class="name"><img src="images/logo1.png" height="18px"></span>
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
                <input type="text" id="search-user" placeholder="Search for users. . .">

                <div>
                    <table id="user-table">
                        <tr class="header">
                            <th>
                                <input type="checkbox" id="selectAllUsers" onclick="toggleSelectAll(this)">
                            </th>
                            <th>Name<i class='bx bx-sort-alt-2'></i></th>
                            <th>Username<i class='bx bx-sort-alt-2'></i></th>
                            <th>Birthday<i class='bx bx-sort-alt-2'></i></th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="user-body">
                            <?php
                            $res=mysqli_query($link, "select * from users");
                            while($row=mysqli_fetch_array($res)) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='checkbox'></td>";                                
                                echo "<td>"; echo $row["firstname"] . " "; if (!empty($row["middle"])) { echo $row["middle"] . ". "; } echo $row["lastname"]; echo "</td>";
                                echo "<td>"; echo $row["username"]; echo "</td>";
                                echo "<td>"; echo $row["birthday"]; echo "</td>";                                
                                echo "<td>"; echo $row["email"]; echo "</td>";
                                echo "<td>"; echo $row["phone"]; echo "</td>";
                                echo "<td>";
                                if ($row["status"] == 'pending') {
                                    echo "<p style='background-color: red; color: white; padding: 0;'>" . $row["status"] . "</p>";
                                } else if ($row["status"] == 'approved') {
                                    echo "<p style='background-color: green; color: white; padding: 0;'>" . $row["status"] . "</p>";
                                }
                                echo "</td>";
                                echo "<td>"; ?> 
                                <a href="viewuser.php?id= <?php echo $row["id"]; ?>"><button>View</button></a></td>
                                <?php echo "</tr>";
                            }
                        ?>
                        </tbody>
                    </table>

                    <div class="pagination" id="pagination"></div>
                </div>
            </div>
        </section>
        <script src="admin.js"></script>
</body>

</html>