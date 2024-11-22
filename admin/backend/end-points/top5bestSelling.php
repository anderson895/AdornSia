<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5bestSelling();

if ($orders) {
    echo "<ul>";  // Start the list here
    
    $rank = 1;
    foreach ($orders as $order) {
        echo '
            <li class="text-sm text-gray-600">
                ' . $order['prod_name'] . ' - ' . $order['prod_image'] . '
            </li>
        ';
        $rank++;
    }

    echo "</ul>";  // End the list here
} else {
    echo "<p>No data available or an error occurred.</p>";
}
?>
