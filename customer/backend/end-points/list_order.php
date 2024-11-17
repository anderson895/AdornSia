<header class="bg-red-500 text-white py-4 px-6">
  <h1 class="text-xl font-bold">My Purchases</h1>
</header>

<div class="flex flex-col lg:flex-row">
  <!-- Sidebar -->
  <aside class="w-full lg:w-64 bg-white shadow-lg h-auto lg:h-screen">
    <div class="p-6">
      <div class="flex items-center gap-3">
        <div class="bg-gray-300 rounded-full h-12 w-12"></div>
        <div>
          <p class="font-bold">joshuaanderson...</p>
          <a href="#" class="text-blue-500 text-sm">Edit Profile</a>
        </div>
      </div>
    </div>
    <nav class="p-6 space-y-4">
      <a href="#" class="block text-gray-600 hover:text-red-500">My Account</a>
      <a href="#" class="block text-red-500 font-bold">My Purchases</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Tabs -->
    <div class="flex flex-wrap space-x-0 space-y-2 md:space-y-0 md:space-x-4 border-b mb-6">
      <a href="#" class="py-2 px-4 border-b-2 border-red-500 text-red-500">All</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500">To Pay</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500">To Ship</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500">To Receive</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500">Completed</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500">Cancelled</a>
      <a href="#" class="py-2 px-4 text-gray-600 hover:text-red-500">Return/Refund</a>
    </div>

    <!-- Order Cards -->
    <div class="space-y-4">
      <!-- Order 1 -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
          <h2 class="font-bold">Heartbeat Sports</h2>
          <div class="flex gap-2">
            <button class="bg-gray-100 px-3 py-1 text-sm rounded">Chat</button>
            <button class="bg-gray-100 px-3 py-1 text-sm rounded">View Shop</button>
          </div>
        </div>
        <div class="flex flex-wrap items-center gap-4">
          <img src="https://via.placeholder.com/80" alt="Product Image" class="w-20 h-20 object-cover">
          <div>
            <h3 class="font-bold">Dumbbell 20KG/30KG/50KG Dumbbell Set</h3>
            <p class="text-sm text-gray-600">Variation: 30 KG [66LBS]</p>
            <p class="text-sm text-gray-500 line-through">₱10,899</p>
            <p class="font-bold text-red-500">₱2,399</p>
          </div>
        </div>
        <div class="flex flex-wrap justify-between items-center mt-4 gap-2">
          <p class="text-sm text-gray-600">Cancelled automatically by Shopee's system</p>
          <button class="bg-red-500 text-white px-4 py-2 rounded">Buy Again</button>
        </div>
      </div>

      <!-- Order 2 -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
          <h2 class="font-bold">CHOSOP.ph</h2>
          <div class="flex gap-2">
            <button class="bg-gray-100 px-3 py-1 text-sm rounded">Chat</button>
            <button class="bg-gray-100 px-3 py-1 text-sm rounded">View Shop</button>
          </div>
        </div>
        <div class="flex flex-wrap items-center gap-4">
          <img src="https://via.placeholder.com/80" alt="Product Image" class="w-20 h-20 object-cover">
          <div>
            <h3 class="font-bold">No more bed bugs! CP Bed bugs spray</h3>
            <p class="text-sm text-gray-600">Variation: Buy 1 Free 1</p>
            <p class="text-sm text-gray-500 line-through">₱552</p>
            <p class="font-bold text-red-500">₱269</p>
          </div>
        </div>
        <div class="flex flex-wrap justify-between items-center mt-4 gap-2">
          <p class="text-sm text-green-500 font-bold">Parcel has been delivered</p>
          <button class="bg-red-500 text-white px-4 py-2 rounded">Buy Again</button>
        </div>
      </div>
    </div>
  </main>
</div>
