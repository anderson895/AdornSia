<?php
include('../class.php');
$db = new global_class();

// Retrieve sender ID and message from POST
$sender_id = $_POST['mess_sender_id'];
$sender_Messages = $_POST['sender_Messages'];

header('Content-Type: application/json'); // Set content type to JSON

if (isset($_POST['requestType']) && $_POST['requestType'] == 'SentMessage') {
    // Sanitize inputs
    $sender_id = htmlspecialchars(trim($sender_id));
    $sender_Messages = htmlspecialchars(trim($sender_Messages));

    // Initialize fileName variable
    $fileName = '';

    // File upload handling
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = basename($_FILES['file']['name']); // Get only the file name
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file type and size
        $allowedfileExtensions = ['jpg', 'jpeg', 'png','webp','svg'];
        $maxFileSize = 10 * 1024 * 1024; // 10 MB limit

        if (in_array($fileExtension, $allowedfileExtensions) && $fileSize <= $maxFileSize) {
            // Define the upload directory
            $uploadFileDir = '../../../upload_message/';
            
            // Generate a unique file name using the original filename
            $newFileName = uniqid('file_', true) . '.' . $fileExtension; // Keep the extension
            
            // Full destination path
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update the fileName variable with the unique name
                $fileName = $newFileName; 
            } else {
                echo json_encode(['error' => 'Error moving uploaded file.']);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Invalid file type or size exceeded.']);
            exit;
        }
    }

    // Send the message with the filename (if available)
    $messageResponse = $db->sentMessage($sender_id, $sender_Messages, $fileName);

    // Provide response based on the result of sending the message
    if ($messageResponse === 'Message sent!') {
        echo json_encode(['success' => 'Message sent successfully!', 'file' => $fileName]); // Success response
    } else {
        echo json_encode(['error' => $messageResponse]); // Error in message sending
    }
} else {
    echo json_encode(['error' => 'Access Denied! No Request Type.']); // Access denied response
}
