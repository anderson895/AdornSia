<?php
include('../class.php');
$db = new global_class();
session_start();
$userId = $_SESSION['acc_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'updateCartQtyMinus') {
            echo $db->updateCart($_POST['id'], 'desc');
        } elseif ($_POST['requestType'] == 'updateCartQtyAdd') {
            echo $db->updateCart($_POST['id'], 'inc');
        } elseif ($_POST['requestType'] == 'updateCartQty') {
            echo $db->updateCartQty($_POST['id'], $_POST['inputQty']);
        } elseif ($_POST['requestType'] == 'deleteCartItem') {
            echo $db->updateCart($_POST['id'], 'delete');
        } elseif ($_POST['requestType'] == 'deleteAllCartItem') {
            echo $db->deleteAllItemsInCart($userId);
        } else {
            echo 'Else';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
