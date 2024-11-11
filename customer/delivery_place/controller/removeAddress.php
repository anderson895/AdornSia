<?php
print_r($_POST);

include("../../../../connection.php");

date_default_timezone_set('Asia/Manila');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acc_id = $_POST["acc_id"];
    $address_id = $_POST["address_id"];

    // Retrieve existing address details
    $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id ='$address_id'");
    $row = mysqli_fetch_assoc($get_record);
    $db_address_complete_name = $row["address_complete_name"];
    $db_address_status = $row["address_status"];
    $db_address_rate = $row["address_rate"];

    // Prepare the SQL statement
    $sql = "UPDATE tbl_address SET address_display_status = ? WHERE address_id = ?";

    // Use a prepared statement to update the address
    if ($stmt = $connections->prepare($sql)) {
        $address_display_status = 0;
        $stmt->bind_param("ii", $address_display_status, $address_id);

        if ($stmt->execute()) {
            echo "Address deleted successfully.";

            // Log the update in the user activity log
            mysqli_query($connections, "INSERT INTO users_log (act_account_id, act_activity, act_date, act_table, act_collumn_id) 
                VALUES ('$acc_id', 'Remove $db_address_complete_name', NOW(), 'address', $address_id)");
        } else {
            echo "Error updating shipping: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $connections->error;
    }
}

$connections->close();
?>
