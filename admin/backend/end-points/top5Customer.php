<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5Customer();

if ($orders) {
    $response = "
    <h3 class='text-center text-gray-700 font-semibold text-lg mb-4'>Top 5 Customers</h3>
    <ul class='space-y-4'>"; 
    foreach ($orders as $order) {
        $response .= '
            <li class="flex flex-col sm:flex-row items-center sm:space-x-6 bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <div class="w-16 h-16 sm:w-20 sm:h-20">
                    <img src="../../../upload/' . $order['Profile_images'] . '" alt="' . $order['Profile_images'] . '" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="flex-1 mt-3 sm:mt-0">
                    <h4 class="text-gray-700 font-semibold text-lg sm:text-xl text-center sm:text-left">' . ucfirst($order['Fullname']) . '</h4>
                    <p class="text-gray-500 text-sm sm:text-base text-center sm:text-left">Total Orders: ' . $order['total_orders'] . '</p>
                    <p class="text-gray-500 text-sm sm:text-base text-center sm:text-left">Total Spent: PHP ' . number_format($order['total_spent'], 2) . '</p>
                </div>
            </li>
        ';
    }
    $response .= "</ul>"; 
    echo $response;
} else {
    echo "<p class='text-gray-500 text-center'>No data available or an error occurred.</p>";
}
?>