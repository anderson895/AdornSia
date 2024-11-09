<?php include "header.php" ?>

<div class="bg-gray-100 flex items-center justify-center min-h-screen">
  
  <!-- Registration Area -->
  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg relative">
    
    <!-- Spinner -->
     <div id="spinner" style="display:none;">
        <div class=" absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
          <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
     </div>
   

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Register with ADORN SIA</h2>
    
    <form id="FrmRegister" class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" id="name" name="name" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500" required>
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500" required>
      </div>

      <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input type="tel" id="phone" name="phone" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500" required>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500" required>
      </div>

      <div>
        <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500" required>
      </div>

      <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75">Register</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      Already have an account? <a href="login.php" class="text-indigo-600 hover:text-indigo-500" id="btnRegister">Log in</a>
    </p>
  </div>

</div>

<?php include "footer.php";?>
