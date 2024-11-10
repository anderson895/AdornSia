<?php
include('../class.php');
$db = new global_class();
session_start();
$userId = $_SESSION['acc_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['requestType'])) {
        if ($_GET['requestType'] == 'GetPaymentTypes') {
            $paymentTypesArray = [];
            $checkIfCODisAllowed = $db->getUserShippingFee($userId);
            if($checkIfCODisAllowed->num_rows > 0){
                $checkCOD = $checkIfCODisAllowed->fetch_assoc();
                if($checkCOD['codAvail'] == 1) {
                    $data = [
                        'payment_id' => 'cod',
                        'payment_code' => 'cod',
                        'payment_name' => 'Cash On Delivery',
                        'payment_number' => '',
                        'payment_image' => ''
                        ];
                        $paymentTypesArray[] = $data;
                }
            }
            $paymentTypes = $db->getPaymentTypes();
            if ($paymentTypes->num_rows > 0) {
                while ($payment = $paymentTypes->fetch_assoc()) {
                    $data = [
                        'payment_id' => $payment['payment_id'],
                        'payment_code' => $payment['payment_code'],
                        'payment_name' => $payment['payment_name'],
                        'payment_number' => $payment['payment_number'],
                        'payment_image' => $payment['payment_image']
                    ];
                    $paymentTypesArray[] = $data;
                }

                echo json_encode($paymentTypesArray);
            }
        } elseif ($_GET['requestType'] == 'GetCartCount') {
            $getCartCount = $db->getCartItems($userId);
            if($getCartCount->num_rows > 0){
                echo $getCartCount->num_rows;
            } else {
                echo 0;
            }
        } else {
            echo 'Else';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'EditUser') {
            echo $db->editUser($_POST, $userId);
        } else {
            echo 'asd';
        }
    } else {
            echo 'asd1';
        }
}
