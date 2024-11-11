<?php
include("../../../../connection.php");

date_default_timezone_set('Asia/Manila');

$acc_id = $_POST["acc_id"];
$shipping = $_POST["shipping"];
$activeStatus = $_POST["activeStatus"];
// $deliveryAllowed = $_POST["deliveryAllowed"];
// $paymentfirstAllowed = $_POST["paymentfirstAllowed"];
$restoration = $_POST["restoration"];

// Fetch the JSON data from the API endpoints
$regionData = file_get_contents('../../../../ph-json/region.json');
$provinceData = file_get_contents('../../../../ph-json/province.json');
$cityData = file_get_contents('../../../../ph-json/city.json');
$barangayData = file_get_contents('../../../../ph-json/barangay.json');

// Decode the JSON data
$regionData = json_decode($regionData, true);
$provinceData = json_decode($provinceData, true);
$cityData = json_decode($cityData, true);
$barangayData = json_decode($barangayData, true);

$regionId = $_POST["region"];
$provinceId = $_POST["province"];
$cityId = $_POST["city"];
$barangayId = $_POST["barangay"];
$restoration = $_POST["restoration"];

// Find the names based on the selected IDs
foreach ($regionData['data'] as $item) {
    if ($item['region_code'] === $regionId) {
        $region_code = $item['region_code'];
        $region = $item['region_name'];
    }
}

foreach ($provinceData['data'] as $item) {
    if ($item['province_code'] === $provinceId) {
        $province_code = $item['province_code'];
        $province = $item['province_name'];
    }
}

foreach ($cityData['data'] as $item) {
    if ($item['city_code'] === $cityId) {
        $city_code = $item['city_code'];
        $city = $item['city_name'];
    }
}

foreach ($barangayData['data'] as $item) {
    if ($item['brgy_code'] === $barangayId) {
        $brgy_code = $item['brgy_code'];
        $barangay = $item['brgy_name'];
    }
}

$completeAddress = $region . " " . $province . " " . $city . " " . $barangay;


$updateQuery = "UPDATE tbl_address 
    SET address_complete_name = '$completeAddress', 
        address_rate = $shipping,
        address_display_status = 1
    WHERE address_code = '$brgy_code'";

$result = mysqli_query($connections, $updateQuery);

if ($result) {
    // Start user log
    mysqli_query($connections, "INSERT INTO users_log(act_account_id, act_activity, act_date, act_table, act_collumn_id) 
        VALUES('$acc_id', 'restore new address: $completeAddress', NOW(),'address','$brgy_code')");
    // End user log

    echo "Address updated successfully!";
} else {
    echo "Error in updating the address: " . mysqli_error($connections);
}


?>
