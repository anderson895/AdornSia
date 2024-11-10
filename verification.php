<?php 
include "header.php"; 
include('backend/class.php');

$db = new global_class();

$resendEnabled = false;  // Set default value for resend button

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if userId is set in the URL
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];
        $verify_account = $db->verify_account($userId); 

        if ($verify_account == "Link has expired") {
            echo "<script>alertify.error('Link has expired');</script>";
            $resendEnabled = true;  // Enable resend button if the link expired
        } else {
            echo "<script>window.location.href = 'customer/';</script>";
        }
    } 
}
?>

<div class="w-full bg-gray-50 py-16">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Verification Link Sent to <span id="Verification_Email" class="text-indigo-600 font-semibold"></span></h1>
        <p class="text-gray-600 mb-6">A verification link has been sent to your email address. Please check your inbox and verify your account.</p>
        <p class="text-sm text-gray-500">If you don’t see the email, check your spam folder or try requesting another verification link.</p>
        
        <!-- Loading Spinner (Hidden by default) -->
        <div id="loadingSpinner" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
            <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
        
        <!-- Resend Link Button -->
        <button 
            type="button" 
            id="resendLink" 
            data-userId="<?=$userId?>" 
            <?php echo $resendEnabled ? '' : 'disabled'; ?>
            class="mt-6 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300 disabled:bg-gray-400"
        >
            Resend Link
        </button>
    </div>
</div>

<!-- jQuery and Alertify.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- Alertify CSS (Optional for styling) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

<!-- JavaScript to handle resend -->

<?php include "footer.php"; ?>
