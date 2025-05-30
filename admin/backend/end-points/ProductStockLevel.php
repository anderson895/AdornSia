<?php
include('../class.php');
$db = new global_class();

$orders = $db->StockLevel();


if ($orders) {
    $response = "
  
    <ul class='space-y-4'>"; 
 
    foreach ($orders as $order) {

        $colorClass = '';
        switch ($order['stock_status']) {
            case 'Out of Stock':
                $colorClass = 'text-red-600';
                break;
            case 'Critical':
                $colorClass = 'text-yellow-600';
                break;
            case 'Normal':
                $colorClass = 'text-green-600';
                break;
            default:
                $colorClass = 'text-gray-600';
                break;
        }

        $response .= '
            <li class="flex flex-col sm:flex-row items-center sm:space-x-4 bg-white p-4 rounded-lg shadow-md">
                <div class="w-16 h-16 sm:w-20 sm:h-20">
                    <img src="../upload/' . $order['prod_image'] . '" alt="' . $order['prod_name'] . '" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="flex-1 mt-2 sm:mt-0">
                    <h4 class="text-gray-700 font-semibold text-lg">' . ucfirst($order['prod_name']) . '</h4>
                </div>
                <div class="flex-1 mt-2 sm:mt-0">
                    <h4 class="text-gray-600 text-sm '.$colorClass.'">' . $order['stock_status'] . ' '.$order['product_stocks'].' pcs </h4>
                </div>
            </li>
        ';
    }
    $response .= "</ul>"; 
    echo $response;
} else {
    echo "<p class='text-gray-500'>No data available or an error occurred.</p>";
}
?>
