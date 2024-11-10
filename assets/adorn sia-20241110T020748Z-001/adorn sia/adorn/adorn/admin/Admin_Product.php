<?php include '../server.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adorn</title>
    <link rel="stylesheet" href="admin/Adornadmin_product.css">
    <script src="Adornadmin_product.js" defer></script>
</head>

<body>
    <header>
        <div class="logo">
        <img src="images/footer_logo2.png" alt="Logo" class="side-logo">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="Admin_Product.php" class="active">Products</a></li>
                <li><a href="who.php">Who we are</a></li>
                <li><a href="#contact">Contact us</a></li>
            </ul>
        </nav>
        <div class="header-icons">
            <a href="#search" class="icon">
                <img src="search.png" alt="Search Icon">
            </a>
            <a href="#cart" class="icon">
                <img src="cart.png" alt="Cart Icon">
            </a>
            <div class="hamburger-menu">
                <img src="hamburger.png" alt="Menu Icon" class="menu-icon" onclick="toggleMenu()">
                <div class="dropdown-menu">
                    <img src="close.png" alt="Close Icon" class="close-menu" onclick="toggleMenu()">
                    <a href="#login">Log In</a>
                    <a href="#signup">Sign Up</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Side Panel -->
    <div class="side-panel">
        <button class="add-category-btn" onclick="toggleCategoryForm()">+ Product Category</button>

        <div class="category-form" id="categoryForm" style="display: none;">
            <form action="Admin_Product.php" method="POST">
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
                    echo '<div class="category-div" data-link="Admin_Product.php?category_id=' . $category_id . '">
                            <span>' . $category_name . '</span>
                            <a href="Admin_Product.php?delete_category_id=' . $category_id . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this category?\')">❌</a>
                        </div>';
                }
            } else {
                echo '<div>No categories available.</div>';
            }
            ?>
        </div>
    </div>

    <!-- products  -->
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
                    <th style="width: 10%;">Price</th>
                    <th style="width: 25%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><img src="../<?php echo $product['product_image']; ?>" alt="Product Image" width="50"></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['product_category_name']; ?></td>
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
        <span class="close-btn" onclick="closeAddModal()">&times;</span>
        <h2>Add New Product</h2>
        <form action="Admin_Product.php?category_id=<?php echo $_GET['category_id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="file" name="product_image" placeholder="Product Image" required><br>
            <input type="text" name="product_name" placeholder="Product Name" required><br>
            <select name="product_category_name" required>
                <option value="" disabled selected>Select Product Type</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['product_category_id']; ?>">
                        <?php echo $category['product_category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" name="product_price" placeholder="Product Price" required><br>
            <input type="hidden" name="category_id" value="<?php echo $_GET['category_id']; ?>">
            <button type="submit" name="add_product">Add Item</button>
            <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
        </form>
    </div>
</div>

<!-- Modal Structure for Editing Product -->

<div id="edit_product_modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <h2>Edit Product</h2>
        <form id="editProductForm" method="POST" enctype="multipart/form-data" action="Admin_Product.php">
            <input type="hidden" id="edit_product_id" name="product_id">
            <input type="file" id="edit_product_image" name="product_image"><br>
            <input type="text" id="edit_product_name" name="product_name" placeholder="Product Name" required><br>
            <select id="edit_product_category_name" name="product_category_name" required>
                <option value="" disabled selected>Select Product Type</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['product_category_id']; ?>">
                        <?php echo $category['product_category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <input type="text" id="edit_product_price" name="product_price" placeholder="Product Price" required><br>
            <button type="submit" name="edit_product">Update Item</button>
            <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
        </form>
    </div>
</div>


<!-- Confirmation Modal for Deletion -->
<div id="deleteConfirmationModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
  <form class="modal-content" action="/action_page.php">
    <div class="container">
      <h1>Delete Account</h1>
      <p>Are you sure you want to delete your account?</p>
    
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
      </div>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>





</body>

</html>