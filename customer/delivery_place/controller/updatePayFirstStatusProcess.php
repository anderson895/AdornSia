<?php
print_r($_POST);

include("../../../../connection.php");

date_default_timezone_set('Asia/Manila');
$currentDateTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acc_id = $_POST["acc_id"];
    $address_id = $_POST["address_id"];
    $status_paynow = $_POST["address_paynow"];

    if($status_paynow!="1"){
        $status_log="Allowed";
    }else{
        $status_log="Not Allowed";
    }

    // Retrieve existing category details
    $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id = '$address_id'");
    $row = mysqli_fetch_assoc($get_record);
    $db_status_paynow = $row["address_paynow"];

    // Prepare the SQL statement
    $sql = "UPDATE tbl_address SET address_paynow = ?, address_date_edited = ? WHERE address_id = ?";

    // Use a prepared statement to update the category
    if ($stmt = $connections->prepare($sql)) {
        $stmt->bind_param("ssi", $status_paynow, $currentDateTime, $address_id);

        if ($stmt->execute()) {
            echo "Category updated successfully.";

            // Start Log the update in the user activity log
            $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id ='$address_id'");
            $row = mysqli_fetch_assoc($get_record);
            $address_complete_name = $row["address_complete_name"];

            
                // Insert the activity log if there's any change
                mysqli_query($connections, "INSERT INTO users_log (act_account_id, act_activity, act_date,act_table,act_collumn_id) 
                VALUES ('$acc_id', 'Set `$address_complete_name` $status_log Payment first', '$currentDateTime','shipping',$address_id)");
            
        } else {
            echo "Error updating category: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $connections->error;
    }
}

$connections->close();
?>
