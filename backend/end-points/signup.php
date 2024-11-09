<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'Signup') {


            $name=$_POST['name'];
            $email=$_POST['email'];
            $phone=$_POST['phone'];
            $password=$_POST['password'];

            echo $db->SignUp($name,$email,$phone,$password);
        } else {
            echo 'Else';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>