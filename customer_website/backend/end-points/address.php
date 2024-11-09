<?php
include ('../class.php');
$db = new global_class();
session_start();
$userId = $_SESSION['acc_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'EditAddress') {
            echo $db->updateAddress($_POST);
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
