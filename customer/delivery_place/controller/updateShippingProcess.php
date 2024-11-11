<?php
print_r($_POST);

include("../../../../connection.php");

date_default_timezone_set('Asia/Manila');
$currentDateTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acc_id = $_POST["acc_id"];
    $address_id = $_POST["address_id"];
    $shipping = $_POST["shipping"];
    $rider_id=$_POST["rider_id"];
    // Retrieve existing category details
    $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id  = '$address_id'");
    $row = mysqli_fetch_assoc($get_record);
    $db_address_rate = $row["address_rate"];

    // Prepare the SQL statement
    $sql = "UPDATE tbl_address SET address_rate = ?,address_rider = ?, address_date_edited = ? WHERE address_id = ?";

    // Use a prepared statement to update the shipping
    if ($stmt = $connections->prepare($sql)) {
        $stmt->bind_param("sisi", $shipping,$rider_id, $currentDateTime, $address_id);

        if ($stmt->execute()) {
            echo "shipping updated successfully.";

            // Start Log the update in the user activity log
            $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id ='$address_id'");
            $row = mysqli_fetch_assoc($get_record);
            $address_complete_name = $row["address_complete_name"];
            $updated_db_address_rate = $row["address_rate"];

            if ($shipping != $db_address_rate) {
                // Insert the activity log if there's any change
                mysqli_query($connections, "INSERT INTO users_log (act_account_id, act_activity, act_date,act_table,act_collumn_id) 
                VALUES ('$acc_id', 'Update `$address_complete_name` shipping price from $db_address_rate changed to `$updated_db_address_rate`', '$currentDateTime','shipping',$address_id)");
            }
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
