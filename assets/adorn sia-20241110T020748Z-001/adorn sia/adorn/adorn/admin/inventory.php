<?php include "../server.php"; ?>
<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
    <title>Inventory - Adorn.</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Adornadmin.css">
    <link rel="icon" type="image/x-icon" href="/images/logo2.png">
    <link rel="stylesheet" href="Adornadmin_product.css">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="images\nav_logo2.png" alt="Adorn">
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

    <section class="home">
        <div class="text">Inventory</div>

        <div class="side-panel">
            <button class="add-category-btn" onclick="toggleCategoryForm()">+ Product Category</button>

            <div class="category-form" id="categoryForm" style="display: none;">
                <form action="inventory.php" method="POST">
                    <label for="category-name">Product Category Name:</label>
                    <input type="text" id="category-name" name="category_name" required>
                    <button type="submit" name="add_category">Add Category</button>
                </form>
            </div>

            <div class="categories-list" id="categoriesList">
                <h3>Product Categories:</h3>
                <?php if (count($categories) > 0) {
                foreach ($categories as $category) {
                    $category_id = $category['product_category_id'];
                    $category_name = htmlspecialchars($category['product_category_name']);
                    
                    // Use a data-link attribute to store the URL and add the delete button inside the div
                    echo '<div class="category-div" data-link="inventory.php?category_id=' . $category_id . '">
                            <span>' . $category_name . '</span>
                            <a href="inventory.php?delete_category_id=' . $category_id . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this category?\')">❌</a>
                        </div>';
                }
            } else {
                echo '<div>No categories available.</div>';
            }
            ?>
            </div>
        </div>

        <div class="product-details">
            <div class="header-container">
                <h3 class="product-details-title">Product Details</h3>
                <button class="add-product-btn" onclick="openModal()">+ Product</button>
            </div>

            <table class="product-table">
                <thead>
                    <tr style="width: 100%;">
                        <th style="width: 9%;">Product ID</th>
                        <th style="width: 20%;">Product Image</th>
                        <th style="width: 21%;">Name of Product</th>
                        <th style="width: 15%;">Type of Product</th>
                        <th style="width: 15%;">Product Description</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 25%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                    <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><img src="../<?php echo $product['product_image']; ?>" alt="Product Image" style="width: 50px; height: 120px;"></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['product_category_name']; ?></td>
                        <td><?echo htmlspecialchars($product_description, ENT_QUOTES, 'UTF-8'); ?> 
                        <td><?php echo number_format($product['product_price'], 2); ?></td>
                    <td>
                        <button class="edt-button" onclick="editProduct(<?php echo $product['product_id']; ?>)">Edit</button>
                        <button class="dlt-button" onclick="confirmDelete(<?php echo $product['product_id']; ?>)">Delete</button>
                    </td>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

 <!-- Modal Structure for Adding Product -->
        <div id="add_product_modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Add New Product</h2>
                <form action="inventory.php?category_id=<?php echo isset($_GET['category_id']) ? htmlspecialchars($_GET['category_id']) : ''; ?>" method="POST" enctype="multipart/form-data">                    <input type="file" name="product_image" placeholder="Product Image (text)" required><br>
                    <input type="text" name="product_name" placeholder="Product Name" required><br>
                    <input type="text" name="product_description" placeholder="Product Description" required><br>

                    <!-- Dropdown for Product Type -->
                    <select name="product_category_name" required>
                        <option value="" disabled selected>Select Product Type</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['product_category_id']; ?>">
                            <?php echo $category['product_category_name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select><br>

                    <input type="text" name="product_price" placeholder="Product Price" required><br>

                    <!-- Add hidden field for category_id to persist the selected category -->
                    <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? htmlspecialchars($_GET['category_id']) : ''; ?>">
                    <button type="submit" name="add_product">Add Item</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button> <!-- Cancel button -->
                </form>
            </div>
        </div>
    </section>

<!-- Modal Structure for Editing Product -->
<div id="edit_product_modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Edit Product</h2>
                <form action="inventory.php?category_id=<?php echo isset($_GET['category_id']) ? htmlspecialchars($_GET['category_id']) : ''; ?>" method="POST" enctype="multipart/form-data">                    <input type="file" name="product_image" placeholder="Product Image (text)" required><br>
                    <input type="text" name="product_name" placeholder="Product Name" required><br>
                    <input type="text" name="product_description" placeholder="Product Description" required><br>

                    <!-- Dropdown for Product Type -->
                    <select name="product_category_name" required>
                        <option value="" disabled selected>Select Product Type</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['product_category_id']; ?>">
                            <?php echo $category['product_category_name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select><br>

                    <input type="text" name="product_price" placeholder="Product Price" required><br>

                    <!-- Add hidden field for category_id to persist the selected category -->
                    <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? htmlspecialchars($_GET['category_id']) : ''; ?>">
                    <button type="submit" name="edit_product">Edit Item</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button> <!-- Cancel button -->
                </form>
            </div>
        </div>
    </section>

    <script src="Adornadmin_product.js"></script>
    <script>
        document.querySelectorAll('.category-div').forEach(function(div) {
            div.addEventListener('click', function(e) {
                // Prevent navigation if the delete button is clicked
                if (!e.target.classList.contains('delete-btn')) {
                    window.location.href = div.getAttribute('data-link');
                }
            });
        });
    </script>
</body>

</html>