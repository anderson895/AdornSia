<?php
session_start();

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']); // Assuming user ID is stored in session after login


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
        <a href="profile.php" class="text-gray-700 hover:text-blue-600 transition">Profile</a>
        <a href="logout.php" class="text-gray-700 hover:text-blue-600 transition">Logout</a>
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

