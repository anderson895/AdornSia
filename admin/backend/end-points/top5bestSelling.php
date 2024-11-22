<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5bestSelling();

if ($orders) {
    $response = "<ul class='space-y-4'>";  // Add some spacing between list items
    $rank = 1;
    foreach ($orders as $order) {
        $response .= '
            <li class="flex items-center space-x-4">
                <div class="w-16 h-16">
                    <img src="../../../upload/' . $order['prod_image'] . '" alt="' . $order['prod_name'] . '" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="flex-1">
                    <h4 class="text-gray-700 font-semibold">' . $rank . '. ' . $order['prod_name'] . '</h4>
                </div>
            </li>
        ';
        $rank++;
    }
    $response .= "</ul>";  // Close the list
    echo $response;
} else {
    echo "<p class='text-gray-500'>No data available or an error occurred.</p>";
}
?>
