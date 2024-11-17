<?php
session_start();

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']); // Assuming user ID is stored in session after login

$Fullname = $_SESSION['Fullname'];
$name_parts = explode(" ", $Fullname);
$firstname = $name_parts[0];
$userID=$_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADORN SIA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="assets/logo1.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <style>
    /* Initially hide the dropdown menu */
    .dropdown-menu {
      display: none;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
  </style>
</head>

<body class="bg-gray-50">
 
 <!-- Header -->
 <header class="bg-white shadow">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <!-- Logo/Brand Name -->
    <div class="text-xl font-bold text-gray-800"><a href="index.php" class="text-gray-700 hover:text-blue-600 transition">ADORN SIA</a></div>
    
    <!-- Navigation Links -->
    <div class="flex items-center space-x-4">
      <?php if ($is_logged_in): ?>
        <!-- Show these if user is logged in -->
        <a href="orders.php" class="text-gray-700 hover:text-blue-600 transition">Orders</a>
        <div class="relative dropdown">
          <!-- Dropdown Trigger -->
          <button id="profileButton" class="flex items-center space-x-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full px-4 py-2">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6"><path d="M21.649 19.875c-1.428-2.468-3.628-4.239-6.196-5.078a6.75 6.75 0 10-6.906 0c-2.568.839-4.768 2.609-6.196 5.078a.75.75 0 101.299.75C5.416 17.573 8.538 15.75 12 15.75c3.462 0 6.584 1.823 8.35 4.875a.751.751 0 101.299-.75zM6.75 9a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0z" fill="#000" class="fill-grey-100"></path></svg>
            <span><?= ucfirst($firstname) ?></span>
          </button>

          <!-- Dropdown Menu -->
          <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg dropdown-menu">
            <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Profile</a>
            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Logout</a>
          </div>
        </div>

      <?php else: ?>
        <!-- Show these if user is not logged in -->
        <a href="login.php" class="text-gray-700 hover:text-blue-600 transition">Login</a>
        <span class="text-gray-500">/</span>
        <a href="signup.php" class="text-gray-700 hover:text-blue-600 transition">Register</a>
      <?php endif; ?>
      
      <a href="view_cart.php" class="relative text-gray-700 hover:text-blue-600 transition text-xl">
          🛒
          <span class="absolute top-0 right-0 inline-block w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full text-center cartCount"></span>
      </a>

    </div>
  </div>
</header>


</body>
</html>
