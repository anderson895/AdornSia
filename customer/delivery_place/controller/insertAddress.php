<?php
include("../../../../connection.php");
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

date_default_timezone_set('Asia/Manila');

$acc_id = $_POST["acc_id"];
$shipping = $_POST["shipping"];
$riderSelect=$_POST['riderSelect'];
$activeStatus = $_POST["activeStatus"];
// $deliveryAllowed = $_POST["deliveryAllowed"];
// $paymentfirstAllowed = $_POST["paymentfirstAllowed"];


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

$query = "SELECT COUNT(*), address_display_status FROM tbl_address WHERE address_code = ?";
$stmt = mysqli_prepare($connections, $query);

if (!$stmt) {
    die("Error in preparing statement: " . mysqli_error($connections));
}

mysqli_stmt_bind_param($stmt, "s", $brgy_code);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $count, $address_display_status);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($count > 0) {
    if ($address_display_status === 1) {
        echo "alreadyAdded";
    } else {
        echo "alreadyDeleted"; 
    }
} else {
    $activeStatus = $activeStatus == "true" ? 1 : 0;

    $insertQuery = "INSERT INTO tbl_address (address_code, muni_code, prov_code, reg_code, address_complete_name, address_rate,address_rider, address_status, address_date_added, address_display_status) 
VALUES (?, ?, ?, ?, ?, ?, ?,?, NOW(), 1)";

$stmt = mysqli_prepare($connections, $insertQuery);

if (!$stmt) {
    die("Error in preparing statement: " . mysqli_error($connections));
}

mysqli_stmt_bind_param($stmt, "ssssssii", $brgy_code, $cityId, $provinceId, $regionId, $completeAddress, $shipping,$riderSelect, $activeStatus);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

    //start user log
    mysqli_query($connections, "INSERT INTO users_log(act_account_id, act_activity, act_date,act_table,act_collumn_id) 
    VALUES('$acc_id', 'Added new address: $completeAddress', NOW(),'address','$brgy_code')");
    //end user log

    echo "Address added successfully!";
}


?>
