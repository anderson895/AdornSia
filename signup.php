<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">

<?php include "header.php"?>


<div class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Registration Area -->
  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Register with ADORN SIA</h2>
    
    <form action="#" method="post" class="space-y-6">
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
      Already have an account? <a href="login.php" class="text-indigo-600 hover:text-indigo-500">Log in</a>
    </p>
  </div>
  

  </div>

</body>
</html>
