<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5bestSelling();

if ($orders) {
    
    $rank = 1;
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>" . $rank . "</td>";
        echo "<td>" . htmlspecialchars($order['prod_name']) . "</td>";
        echo "<td>" . htmlspecialchars($order['prod_image']) . "</td>";
        echo "</tr>";
        $rank++;
    }

    echo "</table>";
} else {
    echo "<p>No data available or an error occurred.</p>";
}
?>
