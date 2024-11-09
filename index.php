<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

  <!-- Header -->
  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="text-xl font-bold">ADORN SIA</div>
     
      <div class="space-x-4 flex items-center">
        <a href="#" class="text-gray-700">Login / Register</a>
        <a href="#" class="text-gray-700">❤️</a>
        <a href="#" class="text-gray-700">🛒</a>
      </div>
    </div>
  </header>

  <div class="container mx-auto px-4 py-6 flex">

    <!-- Sidebar Filters -->
    <aside class="w-1/4 p-4 bg-white rounded shadow-lg">
      <h2 class="font-semibold mb-4">Categories</h2>
      <ul>
        <li><a href="#" class="block py-2 text-gray-700">Women</a></li>
        <li><a href="#" class="block py-2 text-gray-700">Men</a></li>
        <li><a href="#" class="block py-2 text-gray-700">Kids</a></li>
        <li><a href="#" class="block py-2 text-gray-700">Beauty</a></li>
        <li><a href="#" class="block py-2 text-gray-700">Home & Lifestyle</a></li>
      </ul>

      <h2 class="font-semibold mt-6 mb-4">Price</h2>
      <div class="space-y-2">
        <label class="flex items-center">
          <input type="radio" name="price" class="mr-2">
          PHP 0 - PHP 1000
        </label>
        <label class="flex items-center">
          <input type="radio" name="price" class="mr-2">
          PHP 1000 - PHP 2000
        </label>
        <!-- Add more options as needed -->
      </div>
    </aside>

    <!-- Product Grid -->
    <main class="w-3/4 p-4">
      <h1 class="text-2xl font-semibold mb-6">All Products</h1>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <!-- Product Card 1 -->
        <div class="bg-white p-4 rounded shadow-lg">
          <img src="https://dynamic.zacdn.com/A0QGED9oAsSWdYnJLW87Lk0XRdo=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/g2000-6122-3929143-1.jpg" alt="Product Image" class="w-full rounded mb-4">
          <h2 class="font-semibold text-lg">SASSA</h2>
          <p class="text-gray-600">Twinkle Fit 2-in-1 Pack Baby Bra</p>
          <p class="text-lg font-bold text-gray-800">PHP 449.00</p>
        </div>

        <!-- Product Card 2 -->
        <div class="bg-white p-4 rounded shadow-lg">
          <img src="https://dynamic.zacdn.com/ZfzR3CMUWuw6SzzOtAvYP4d23fc=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/krystal-couture-6252-4226433-1.jpg" alt="Product Image" class="w-full rounded mb-4">
          <h2 class="font-semibold text-lg">Twenty Eight Shoes</h2>
          <p class="text-gray-600">Woven Strap Wedge Espadrilles</p>
          <p class="text-lg font-bold text-red-600">PHP 3,368.70</p>
          <p class="text-sm text-gray-500 line-through">PHP 4,167.00</p>
          <p class="text-sm text-green-600">10% off</p>
        </div>

        <!-- Product Card 3 -->
        <div class="bg-white p-4 rounded shadow-lg">
          <img src="https://dynamic.zacdn.com/lbmXAp5Cu75HqNjXe33aBfs81vU=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/vans-1388-9622853-1.jpg" alt="Product Image" class="w-full rounded mb-4">
          <h2 class="font-semibold text-lg">VANS</h2>
          <p class="text-gray-600">Classic Slip-On</p>
          <p class="text-lg font-bold text-red-600">PHP 2,623.50</p>
          <p class="text-sm text-gray-500 line-through">PHP 3,498.00</p>
          <p class="text-sm text-green-600">25% off</p>
        </div>

         <!-- Product Card 3 -->
         <div class="bg-white p-4 rounded shadow-lg">
            <img src="https://dynamic.zacdn.com/lbmXAp5Cu75HqNjXe33aBfs81vU=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/vans-1388-9622853-1.jpg" alt="Product Image" class="w-full rounded mb-4">
            <h2 class="font-semibold text-lg">VANS</h2>
            <p class="text-gray-600">Classic Slip-On</p>
            <p class="text-lg font-bold text-red-600">PHP 2,623.50</p>
            <p class="text-sm text-gray-500 line-through">PHP 3,498.00</p>
            <p class="text-sm text-green-600">25% off</p>
          </div>

           <!-- Product Card 3 -->
        <div class="bg-white p-4 rounded shadow-lg">
            <img src="https://dynamic.zacdn.com/lbmXAp5Cu75HqNjXe33aBfs81vU=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/vans-1388-9622853-1.jpg" alt="Product Image" class="w-full rounded mb-4">
            <h2 class="font-semibold text-lg">VANS</h2>
            <p class="text-gray-600">Classic Slip-On</p>
            <p class="text-lg font-bold text-red-600">PHP 2,623.50</p>
            <p class="text-sm text-gray-500 line-through">PHP 3,498.00</p>
            <p class="text-sm text-green-600">25% off</p>
          </div>


           <!-- Product Card 3 -->
        <div class="bg-white p-4 rounded shadow-lg">
            <img src="https://dynamic.zacdn.com/lbmXAp5Cu75HqNjXe33aBfs81vU=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/vans-1388-9622853-1.jpg" alt="Product Image" class="w-full rounded mb-4">
            <h2 class="font-semibold text-lg">VANS</h2>
            <p class="text-gray-600">Classic Slip-On</p>
            <p class="text-lg font-bold text-red-600">PHP 2,623.50</p>
            <p class="text-sm text-gray-500 line-through">PHP 3,498.00</p>
            <p class="text-sm text-green-600">25% off</p>
          </div>


           <!-- Product Card 3 -->
        <div class="bg-white p-4 rounded shadow-lg">
            <img src="https://dynamic.zacdn.com/lbmXAp5Cu75HqNjXe33aBfs81vU=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/vans-1388-9622853-1.jpg" alt="Product Image" class="w-full rounded mb-4">
            <h2 class="font-semibold text-lg">VANS</h2>
            <p class="text-gray-600">Classic Slip-On</p>
            <p class="text-lg font-bold text-red-600">PHP 2,623.50</p>
            <p class="text-sm text-gray-500 line-through">PHP 3,498.00</p>
            <p class="text-sm text-green-600">25% off</p>
          </div>

        <!-- Add more product cards as needed -->

      </div>
    </main>
  </div>

</body>
</html>
