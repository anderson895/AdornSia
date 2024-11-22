<?php
include('../class.php');
$db = new global_class();

$orders = $db->topNewProduct();

if ($orders) {
    $response = "
    <h3 class='text-gray-700 font-semibold text-lg mb-4'>Top 5 Best Selling Products</h3>
    <ul class='space-y-4'>"; 
    $rank = 1;
    foreach ($orders as $order) {
        $response .= '
            <li class="flex flex-col sm:flex-row items-center sm:space-x-4 bg-white p-4 rounded-lg shadow-md">
                <div class="w-16 h-16 sm:w-20 sm:h-20">
                    <img src="../../../upload/' . $order['prod_image'] . '" alt="' . $order['prod_name'] . '" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="flex-1 mt-2 sm:mt-0">
                    <h4 class="text-gray-700 font-semibold text-lg">' . $rank . '. ' . $order['prod_name'] . '</h4>
                </div>
                <div class="flex-1 mt-2 sm:mt-0">
                    <h4 class="text-gray-600 text-sm">' . $order['total_quantity_sold'] . ' Sold</h4>
                </div>
            </li>
        ';
        $rank++;
    }
    $response .= "</ul>"; 
    echo $response;
} else {
    echo "<p class='text-gray-500'>No data available or an error occurred.</p>";
}
?>
