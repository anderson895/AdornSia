<?php
include('../class.php');
$db = new global_class();

session_start();

$acc_id=$_SESSION['acc_id'];

    $orders = $db->getOrderStatusCounts($acc_id);
   
