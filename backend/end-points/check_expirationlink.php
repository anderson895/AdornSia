<?php
include('../class.php');

$db = new global_class();

// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Get the current date and time
$currentDate = date('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['requestType'])) {
        if ($_GET['requestType'] == 'getExpirationLink') {

            $userId = $_GET['userId'];
            
            $getExpirationLink = $db->getExpirationLink($userId);

            if ($getExpirationLink) {
                // Convert both dates to Unix timestamps for comparison
                $currentTimestamp = strtotime($currentDate);
                $expirationTimestamp = strtotime($getExpirationLink);
            
                // Check if expiration time is in the future or past
                if ($expirationTimestamp > $currentTimestamp) {
                    // Calculate remaining time
                    $remainingTime = $expirationTimestamp - $currentTimestamp;
            
                    $hours = floor($remainingTime / 3600); // Get hours
                    $minutes = floor(($remainingTime % 3600) / 60); // Get minutes
                    $seconds = $remainingTime % 60; // Get remaining seconds
            
                    $timeString = "Remaining time: ";
            
                    // Append hours, minutes, and seconds to the string if they are non-zero
                    if ($hours > 0) {
                        $timeString .= "$hours hours, ";
                    }
                    if ($minutes > 0) {
                        $timeString .= "$minutes minutes, ";
                    }
                    if ($seconds > 0 || ($hours == 0 && $minutes == 0)) {
                        $timeString .= "$seconds seconds";
                    }
            
                    echo rtrim($timeString, ', ') . "."; // Remove trailing comma and space
                } else {
                    echo "Expired";
                }
            }
            

        } else {
            echo 'Else';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
}
?>
