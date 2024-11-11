<?php
    // SQL query to retrieve data from tbl_address
    $sql = "SELECT * FROM tbl_address 
    LEFT JOIN account
    ON tbl_address.address_rider  = account.acc_id
    where address_display_status ='1' ";
    $result = $connections->query($sql);
    
    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        $data = array();
    
        while ($row = $result->fetch_assoc()) {
            // Add each row to the $data array
            $data[] = $row;
        }
    
        // Convert the PHP array to a JSON string
        $data_json = json_encode($data);
    
        // Generate JavaScript code to insert data into a JavaScript array
        echo '<script>';
        echo 'var addressData = ' . $data_json . ';';
        echo '</script>';
    } else {
        echo "No data found";
    }
?>