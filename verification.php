<?php 
include "header.php"; 
include('backend/class.php');

$db = new global_class();

$resendEnabled = false;  // Set default value for resend button

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if userId is set in the URL
    if (isset($_GET['userId'])) {
        $userId = htmlspecialchars($_GET['userId']);
        echo "<script>var userId = '{$userId}';</script>";
    
        if(isset($_GET['verificationKey'])){
            $CurrentverificationKey = $_GET['verificationKey'] ?? 0;

           
            // Fetch the verification key and expiration status
            $getVerificationKey = $db->getVerificationKey($userId);
    
            // Decode the JSON result from getVerificationKey method
            $verificationData = json_decode($getVerificationKey, true);
    
            if ($verificationData['isExpired']) {
                echo "<script>alertify.error('Link has expired');</script>";
            } else {
                // Check if the verification key matches
                if ($verificationData['verification_link'] == $CurrentverificationKey) {    
                    // Proceed with account verification
                    $verify_account = $db->verify_account($userId);
                    echo "<script>
                    // Show loading spinner
                    document.body.innerHTML = '<div class=\"fixed inset-0 bg-gray-700 bg-opacity-50 flex justify-center items-center\"><div class=\"loader\"></div></div>';
                    
                    // Create a simple CSS spinner
                    let style = document.createElement('style');
                    style.innerHTML = `
                        .loader {
                            border: 8px solid #f3f3f3;
                            border-top: 8px solid #3498db;
                            border-radius: 50%;
                            width: 50px;
                            height: 50px;
                            animation: spin 2s linear infinite;
                        }
                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                    `;
                    document.head.appendChild(style);
                    
                    // Show success message and wait for a few seconds before redirect
                    alertify.success('Account verified successfully');
                    
                    setTimeout(function() {
                        location.href = 'customer/index.php';
                    }, 3000); // 3-second delay
                </script>";
                
                } else {
                    echo "<script>alertify.error('Invalid Link');</script>";
                }
            }
        }
       
    }
}

?>


<div class="w-full bg-gray-50 py-16">
    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg text-center relative">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Verification Link Sent to 
            <span id="Verification_Email" class="text-indigo-600 font-semibold"></span>
        </h1>
        <p class="text-lg text-gray-600 mb-6">A verification link has been sent to your email address. Please check your inbox and verify your account.</p>
        <p class="text-sm text-gray-500 mb-6">If you don’t see the email, check your spam folder or try requesting another verification link.</p>
        
        <!-- Loading Spinner (Hidden by default) -->
        <div id="loadingSpinner" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
            <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
        
        <!-- Resend Link Button -->
        <div class="flex flex-col items-center">
            <p id="TheRemainingTime" class="text-sm text-gray-500 mb-4">Please wait while we prepare a new link...</p>
            <button 
                type="button" 
                id="resendLink"
                data-userId=<?=$_GET['userId']?>
                class="mt-4 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 disabled:bg-gray-400"
            >
                Resend Link
            </button>
        </div>
    </div>
</div>


<!-- jQuery and Alertify.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- Alertify CSS (Optional for styling) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<script src="javascript/get_expiration.js"></script>
<!-- JavaScript to handle resend -->

<?php include "footer.php"; ?>
