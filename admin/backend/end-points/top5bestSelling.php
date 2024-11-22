<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5bestSelling();

if ($orders) {
    $response = "<ul class='list-disc pl-5'>";  // Start list
    $rank = 1;
    foreach ($orders as $order) {
        $response .= '
            <li class="text-sm text-gray-600 mb-2">
                <strong>' . $rank . '. ' . $order['prod_name'] . '</strong><br>
                <img src="../../../upload/' . $order['prod_image'] . '" alt="' . $order['prod_name'] . '" class="w-16 h-16 object-cover mt-2">
            </li>
        ';
        $rank++;
    }
    $response .= "</ul>";  // End list
    echo $response;
} else {
    echo "<p class='text-gray-500'>No data available or an error occurred.</p>";
}
?>
