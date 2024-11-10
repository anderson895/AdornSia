

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher/Admin Dashboard</title>
  <link rel="icon" type="image/png" href="{{ url_for('static', filename='assets/corgi.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  
 

</head>
<body class="bg-gray-100 font-sans antialiased">
  <div class="min-h-screen flex flex-col lg:flex-row">
    
  <!-- Sidebar -->
<aside id="sidebar" class="bg-white shadow-lg w-64 lg:w-1/5 xl:w-1/6 p-6 space-y-6 lg:static fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
  <!-- Hide Sidebar Button -->
  <h1 class="text-2xl font-bold text-gray-700 mb-6 text-left lg:text-left">Adorn Sia</h1>
  <nav class="space-y-4 text-left lg:text-left">
      <a href="{{ url_for('admin_dashboard') }}" class="flex items-center lg:justify-start space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">dashboard</span>
          <span>Dashboard</span>
      </a>
      
      <a href="{{url_for('admin_attendance')}}" class="flex items-center lg:justify-start space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">group</span>
          <span>Customers</span>
      </a>
      <a href="{{url_for('admin_student_progress')}}" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">store</span>
          <span>Products</span>
      </a>


      <a href="{{url_for('admin_student_progress')}}" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">discount</span>
          <span>Marketing and Promotions</span>
      </a>

      <a href="{{url_for('admin_student_progress')}}" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
          <span class="material-icons">description</span>
          <span>Reports</span>
      </a>

      <a href="{{url_for('admin_student_progress')}}" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-blue-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
            <span class="material-icons">admin_panel_settings</span>

          <span>User Role</span>
      </a>

      <form action="{{ url_for('admin_logout') }}" method="post">
          <button type="submit" class="flex items-center lg:justify-start  space-x-3 text-gray-600 hover:text-red-500 hover:bg-gray-100 px-4 py-2 rounded-md transition-all duration-300">
              <span class="material-icons">logout</span>
              <span>Logout</span>
          </button>
      </form>
  </nav>
</aside>



    <!-- Overlay for Mobile Sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden lg:hidden z-40"></div>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 p-8 lg:p-12">
      <!-- Mobile menu button -->
      <button id="menuButton" class="lg:hidden text-gray-700 mb-4">
        <span class="material-icons">menu</span> 
      </button>

   

     
