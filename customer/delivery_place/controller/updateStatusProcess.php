<?php
print_r($_POST);

include("../../../../connection.php");

date_default_timezone_set('Asia/Manila');
$currentDateTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acc_id = $_POST["acc_id"];
    $address_id = $_POST["address_id"];
    $status = $_POST["address_status"];

    $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id ='$address_id'");
    $row = mysqli_fetch_assoc($get_record);
    $db_address_region_name = $row["address_complete_name"];
    $db_address_status = $row["address_status"];
   

    // Retrieve existing category details
    $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id = '$address_id'");
    $row = mysqli_fetch_assoc($get_record);
    $db_address_rate = $row["address_rate"];

    // Prepare the SQL statement
    $sql = "UPDATE tbl_address SET address_status = ?, address_date_edited = ? WHERE address_id = ?";

    // Use a prepared statement to update the category
    if ($stmt = $connections->prepare($sql)) {
        $stmt->bind_param("ssi", $status, $currentDateTime, $address_id);

        if ($stmt->execute()) {
            echo "Address updated successfully.";

            // Start Log the update in the user activity log
            $get_record = mysqli_query($connections, "SELECT * FROM tbl_address WHERE address_id ='$address_id'");
            $row = mysqli_fetch_assoc($get_record);
            $updated_db_address_complete_name = $row["address_complete_name"];
            $updated_db_address_status = $row["address_status"];


            if($status!="1"){
                $status_log="Disabled";
                
            }else{
                $status_log="Enabled";
            }
            echo "<br> status=",$status;
            echo "<br> updated_db_address_status=",$db_address_status;

           

                // Insert the activity log if there's any change
                mysqli_query($connections, "INSERT INTO users_log (act_account_id, act_activity, act_date,act_table,act_collumn_id) 
                VALUES ('$acc_id', '$status_log `$updated_db_address_complete_name`', '$currentDateTime','shipping',$address_id)");
            
            
            
            
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
