<?php
include('backend/class.php');
$db = new global_class();

session_start();
$is_logged_in = isset($_SESSION['user_id']);
if (isset($_SESSION['user_id'])) {
  $user_id = intval($_SESSION['user_id']); 
  $result = $db->check_account($user_id);

  if (!empty($result)) {
    
  } else {
     header('location: ../login.php');
  }
} else {
 header('location: ../login.php');
}
$userID=$_SESSION['user_id'];


$fetch_user_info = $db->fetch_user_info($userID); 
foreach ($fetch_user_info as $user):
    $user_fullname=$user['Fullname'];
    $user_email=$user['Email'];
    $user_phone=$user['Phone'];
    $user_profileImages=$user['Profile_images'];
endforeach;


$Fullname =$user_fullname;
$name_parts = explode(" ", $Fullname);
$firstname = $name_parts[0];

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
      z-index: 50; /* Ensure the dropdown appears above other elements */
    }








    #loadingScreen {
      position: fixed;
      inset: 0;
      background-color: #ffffff; /* White background */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 100;
      opacity: 1;
      transition: opacity 1s ease-out;
    }

    .loading-icon {
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }



  </style>
</head>

<body class="bg-gray-50">


<!-- Loading Screen (Full-screen white overlay) -->
<div id="loadingScreen" class="flex justify-center items-center">
  <svg class="h-20 w-20 stroke-gray-500 loading-icon" viewBox="0 0 256 256">
    <line x1="128" y1="32" x2="128" y2="64" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="195.9" y1="60.1" x2="173.3" y2="82.7" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="224" y1="128" x2="192" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="195.9" y1="195.9" x2="173.3" y2="173.3" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="128" y1="224" x2="128" y2="192" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="60.1" y1="195.9" x2="82.7" y2="173.3" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="32" y1="128" x2="64" y2="128" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
    <line x1="60.1" y1="60.1" x2="82.7" y2="82.7" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
  </svg>
  <span class="text-4xl font-medium text-gray-500">Loading...</span>
</div>

<script>
  window.onload = function() {
    // Set a 1-second delay before hiding the loading screen
    setTimeout(function() {
      document.getElementById('loadingScreen').style.opacity = '0';
      setTimeout(function() {
        document.getElementById('loadingScreen').style.display = 'none';
      }, 1000); // Hide after the opacity transition is complete
    }, 1000); // Show for 1 second
  };
</script>





 <!-- Header -->
<header class="bg-white shadow">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <!-- Logo/Brand Name -->
    <div class="flex items-center space-x-2">
      <!-- Logo Image -->
      <img src="assets/logo1.png" alt="Logo" class="h-8 w-8"> <!-- Adjust h-8 and w-8 to control size -->
      
      <!-- Brand Name -->
      <div class="text-xl font-bold text-gray-800">
        <a href="index.php" class="text-gray-700 hover:text-blue-600 transition">ADORN</a>
      </div>
    </div>
    
    <!-- Mobile Menu Button -->
    <button id="mobileMenuButton" class="lg:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Navigation Links -->
    <nav id="navigation" class="hidden lg:flex lg:items-center lg:space-x-4">
      <?php if ($is_logged_in): ?>
        <!-- Show these if user is logged in -->
        <a href="index.php" class="text-gray-700 hover:text-blue-600 transition">Products</a>

        <div class="relative dropdown">
          <!-- Dropdown Trigger -->
          <button id="profileButton" class="flex items-center space-x-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full px-4 py-2">
          <?php
          if ($user_profileImages) {
              echo "<img src='../upload/$user_profileImages' class='h-6 w-6 rounded-full'>";
          } else {
              echo '
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6 rounded-full">
                <path d="M21.649 19.875c-1.428-2.468-3.628-4.239-6.196-5.078a6.75 6.75 0 10-6.906 0c-2.568.839-4.768 2.609-6.196 5.078a.75.75 0 101.299.75C5.416 17.573 8.538 15.75 12 15.75c3.462 0 6.584 1.823 8.35 4.875a.751.751 0 101.299-.75zM6.75 9a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0z" fill="#000" class="fill-grey-100"></path>
              </svg>';
          }
          ?>

             <span><?= ucfirst($firstname) ?></span>
          </button>

          <!-- Dropdown Menu -->
          <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg dropdown-menu">
              <a href="orders.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
                  <span class="material-icons align-middle mr-2">shopping_cart</span>
                  My Purchase
              </a>
              <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
                  <span class="material-icons align-middle mr-2">account_circle</span>
                  Profile
              </a>
              <a href="password_setting.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
                  <span class="material-icons align-middle mr-2">lock</span>
                  Password
              </a>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
                  <span class="material-icons align-middle mr-2">exit_to_app</span>
                  Logout
              </a>
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
          <span class="absolute top-0 right-0 inline-block w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full text-center hidden cartCount"></span>
      </a>
      <a href="view_wishlist.php" class="relative text-gray-700 hover:text-blue-600 transition text-xl">
          <span class="material-icons align-middle mr-2">favorite_border</span>
          <span class="absolute top-0 right-0 inline-block w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full text-center hidden wishlistCount"></span>
      </a>
    </nav>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-gray-200">
  <nav class="flex flex-col space-y-2 p-4">
    <?php if ($is_logged_in): ?>
      <a href="index.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">home</span>
        Products
      </a>
     <!-- Cart -->
    <a href="view_cart.php" class="flex items-center text-gray-700 hover:text-blue-600 transition relative">
      <span class="material-icons mr-2">shopping_cart</span>
      Cart
      <span class="absolute top-0 right-0 inline-block w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full text-center cartCount hidden">0</span>
    </a>

    <!-- Wishlist -->
    <a href="view_wishlist.php" class="flex items-center text-gray-700 hover:text-blue-600 transition relative">
      <span class="material-icons mr-2">favorite</span>
      Wishlist
      <span class="absolute top-0 right-0 inline-block w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full text-center wishlistCount hidden">0</span>
    </a>
      <a href="orders.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">shopping_cart</span>
        My Purchase
      </a>
      <a href="profile.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">account_circle</span>
        Profile
      </a>
      <a href="password_setting.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">lock</span>
        Password
      </a>
      <a href="logout.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">exit_to_app</span>
        Logout
      </a>
    <?php else: ?>
      <a href="login.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">login</span>
        Login
      </a>
      <a href="signup.php" class="flex items-center text-gray-700 hover:text-blue-600 transition">
        <span class="material-icons mr-2">person_add</span>
        Register
      </a>
    <?php endif; ?>


  </nav>
</div>


</header>

<script>
  const mobileMenuButton = document.getElementById('mobileMenuButton');
  const mobileMenu = document.getElementById('mobileMenu');
  mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>


