<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADORN SIA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="customer/assets/logo1.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-gray-50">


<?php include "function/PageSpinner.php"; ?>


 <!-- Header -->
 <header class="bg-white shadow">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <!-- Logo/Brand Name -->
    <div class="flex items-center space-x-3">
      <img src="admin/assets/logo1.png" alt="Logo" class="w-12 h-12"> <!-- Logo size adjusted here -->
      <div class="text-xl font-bold text-gray-800"><a href="index.php" class="text-gray-700 hover:text-blue-600 transition">ADORN</a></div>
    </div>
    
    <!-- Navigation Links -->
    <div class="flex items-center space-x-4">
      <a href="login.php" class="text-gray-700 hover:text-blue-600 transition">Login</a>
      <span class="text-gray-500">/</span>
      <a href="signup.php" class="text-gray-700 hover:text-blue-600 transition">Register</a>
      <a href="login.php" class="text-gray-700 hover:text-blue-600 transition text-xl">🛒</a>
    </div>
  </div>
</header>

</body>
</html>
