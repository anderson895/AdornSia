<?php
include('../class.php');
$db = new global_class();

$orders = $db->top5bestSelling();

if ($orders) {
    echo "<h1>Top 5 Best-Selling Products</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Rank</th><th>Product Name</th><th>Quantity Sold</th></tr>";
    
    $rank = 1;
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>" . $rank . "</td>";
        echo "<td>" . htmlspecialchars($order['prod_name']) . "</td>";
        echo "<td>" . htmlspecialchars($order['total_quantity_sold']) . "</td>";
        echo "</tr>";
        $rank++;
    }

    echo "</table>";
} else {
    echo "<p>No data available or an error occurred.</p>";
}
?>
