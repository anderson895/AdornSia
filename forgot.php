<?php include "header.php"?>

<div class="bg-gray-100 flex items-center justify-center min-h-screen">
  <!-- Forgot Password Area -->
  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">

    <!-- Spinner -->
    <div id="spinner" style="display:none;">
      <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
      </div>
    </div>

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Forgot Password</h2>
    
    <p class="text-sm text-gray-600 text-center mb-4">
      Enter your email address below, and we'll send you a link to reset your password.
    </p>
    
    <form id="frmForgotPassword" class="space-y-6">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500" required>
      </div>

      <button type="submit" id="btnForgotPassword" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">
        Request New Password
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      Remembered your password? <a href="login.php" class="text-indigo-600 hover:text-indigo-500">Sign In</a>
    </p>
  </div>
</div>

<?php include "footer.php";?>
