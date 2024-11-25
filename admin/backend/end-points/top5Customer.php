<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5Customer();

if ($orders) {
    $response = "
    <h3 class='text-center text-gray-700 font-semibold text-lg mb-4'>Top 5 Customers</h3>
    <ul class='space-y-4'>"; 
    foreach ($orders as $order) {
        // Check if Profile_images is empty or null
        if (!empty($order['Profile_images'])) {
            $imageTag = '<img src="../../../upload/' . $order['Profile_images'] . '" alt="Profile Image" class="w-full h-full object-cover rounded-lg">';
        } else {
            // Use an inline SVG for the fallback image
            $imageTag = '
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full rounded-lg">
                <path d="M21.649 19.875c-1.428-2.468-3.628-4.239-6.196-5.078a6.75 6.75 0 10-6.906 0c-2.568.839-4.768 2.609-6.196 5.078a.75.75 0 101.299.75C5.416 17.573 8.538 15.75 12 15.75c3.462 0 6.584 1.823 8.35 4.875a.751.751 0 101.299-.75zM6.75 9a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0z" fill="#000" class="fill-grey-100"></path>
            </svg>';
        }

        $response .= '
            <li class="flex flex-col sm:flex-row items-center sm:space-x-6 bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <div class="w-16 h-16 sm:w-20 sm:h-20">
                    ' . $imageTag . '
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
    echo "<p class='text-gray-500 text-center'>No data available</p>";
}
?>
