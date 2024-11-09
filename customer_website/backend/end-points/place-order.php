<?php
include('../class.php');
$db = new global_class();
session_start();
$userId = $_SESSION['acc_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'PlaceOrder') {
            if ($_POST['paymentType'] == 'cod') {
                echo $db->placeOrderCOD($_POST);
            } else {
                echo $db->placeOrderWithPOF($_POST, $_FILES['proofOfPayment']);
            }
        } else {
            echo 'Else';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
