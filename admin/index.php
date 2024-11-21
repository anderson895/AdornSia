<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="assets/logo1.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8 relative">

    <!-- Spinner -->
    <div id="spinner" style="display:none;">
      <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
      </div>
    </div>

    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="assets/logo1.png" alt="Adornasia" class="w-30 h-30 object-contain">
    </div>

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Admin Login</h2>

    <form id="frmLogin" class="space-y-6">
    <div class="relative">
  <input
    type="text"
    id="username"
    name="username"
    required
    class="peer w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-transparent"
    placeholder="Username"
  />
  <label
    for="username"
    class="absolute left-4 top-2 text-sm text-gray-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-blue-500"
  >
    Username
  </label>
</div>

<div class="relative">
  <input
    type="password"
    id="password"
    name="password"
    required
    class="peer w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-transparent"
    placeholder="Password"
  />
  <label
    for="password"
    class="absolute left-4 top-2 text-sm text-gray-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-blue-500"
  >
    Password
  </label>
</div>
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember_me" name="remember_me" type="checkbox" 
                 class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
          <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
        </div>
      </div>

      <div>
        <button type="submit" id="btnLogin" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Sign in
        </button>
      </div>
    </form>
  </div>

  <script src="js/app.js"></script>
</body>
</html>
