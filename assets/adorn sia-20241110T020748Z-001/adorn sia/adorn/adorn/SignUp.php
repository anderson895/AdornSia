<?php include "server.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="Adornstyle.css">    
    <link rel="stylesheet" href="Adornlogin_signup.css">
    <link rel="icon" type="image/x-icon" href="images/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome -->

</head>

<body>
    <!-- Age Verification Modal -->
    <div class="modal">
        <div class="modal-content">
            <h2>Age Verification</h2>
            <p>You must be 18 years or older to access this page. Are you 18 or older?</p>
            <button onclick="verifyAge(true)">Yes, I am 18 or older</button>
            <button class="no-btn" onclick="verifyAge(false)">No, I am under 18</button>
        </div>
    </div>

    <!-- Main Sign-Up Container -->
    <div class="container" id="signup">
        <div class="form-section">
            <h1><img src="images/nav_logo2.png" alt="Adorn"></h1>
            <!-- Registration Form -->
            <form action="signup.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="input-row">
                    <input type="text" id="fn" name="firstname" placeholder="First Name" maxlength="26" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" oninput="this.value = this.value.replace(/[^A-Za-z\s-]/g, '')" required>
                    <input type="text" id="mi" name="middle" placeholder="MI" maxlength="2" class="mi-input" value="<?php echo isset($_POST['middle']) ? $_POST['middle'] : ''; ?>" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '')">
                    <input type="text" id="ln" name="lastname" placeholder="Last Name" maxlength="26" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" oninput="this.value = this.value.replace(/[^A-Za-z\s-]/g, '')" required>
                </div>
                <input type="text" id="un" name="username" placeholder="Username" maxlength="26" class="full-width" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')" required>

                <div class="form-row-double">
                    <input type="email" id="email" name="email" placeholder="Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                    <input type="tel" id="phone" name="phone" placeholder="Phone number" maxlength="11" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>

                <div class="form-row-double">
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="26" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-container">
                        <input type="password" id="confirm" name="confirm" placeholder="Confirm Password" minlength="8" maxlength="26" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirm', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-row-double">
                    <input type="date" id="bday" name="birthday" value="<?php echo isset($_POST['birthday']) ? $_POST['birthday'] : ''; ?>" required>
                </div>

                <select id="idType" name="idType" class="full-width" onchange="enterID()" required>
                    <option value="">Select an ID</option>
                    <option value="National ID" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'National ID') ? 'selected' : ''; ?>>National ID</option>
                    <option value="Passport" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'Passport') ? 'selected' : ''; ?>>Passport</option>
                    <option value="Driver's License" <?php echo (isset($_POST['idType']) && $_POST['idType'] == "Driver's License") ? 'selected' : ''; ?>>Driver's License</option>
                    <option value="SSS ID" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'SSS ID') ? 'selected' : ''; ?>>SSS ID</option>
                    <option value="UMID" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'UMID') ? 'selected' : ''; ?>>UMID</option>
                    <option value="Postal ID" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'Postal ID') ? 'selected' : ''; ?>>Postal ID</option>
                    <option value="PRC ID" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'PRC ID') ? 'selected' : ''; ?>>PRC ID</option>
                    <option value="Pag-Ibig Loyalty Plus" <?php echo (isset($_POST['idType']) && $_POST['idType'] == 'Pag-Ibig Loyalty Plus') ? 'selected' : ''; ?>>Pag-Ibig Loyalty Plus</option>
                </select>

                <input type="text" class="full-width" id="idNumber" name="idNumber" style="display:<?php echo isset($_POST['idType']) && !empty($_POST['idType']) ? 'block' : 'none'; ?>;" value="<?php echo isset($_POST['idNumber']) ? $_POST['idNumber'] : ''; ?>" required>

                <label for="front_id">Take a picture of the front of your ID</label>
                <input type="file" class="full-width" id="front_id" name="front_id" accept="image/*" capture="environment" />
                <?php if (isset($_FILES['front_id']) && $_FILES['front_id']['error'] == 0): ?>
                <?php endif; ?>

                <label for="back_id">Take a picture of the back of your ID</label>
                <input type="file" class="full-width" id="back_id" name="back_id" accept="image/*" capture="environment" />
                <?php if (isset($_FILES['back_id']) && $_FILES['back_id']['error'] == 0): ?>
                <?php endif; ?>


                <!-- Terms and Conditions Checkbox -->
                <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the <a href="javascript:void(0);" onclick="openTermsModal()">Terms and Conditions</a></label>
                </div>
                <div class="button-group">
                    <button type="submit" class="signup-btn" name="signup">SIGN UP</button>
                </div>
                <p class="message" id="signupMessage" style="color: red; text-align: center;">
                    <?php echo isset($errorMessage) ? $errorMessage : ''; ?>
                </p>
            </form>
            <div class="footer-text">
                <p>Already have an account? <a href="login.php">Log In</a></p>
            </div>
        </div>
        <div class="image-section"></div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="terms-modal">
        <div class="terms-modal-content">
            <h2>Terms and Conditions for ADORN</h2>
            <p><strong>Effective Date: October 25, 2024</strong></p>
            <div class="terms-modal-body">
                <p>Welcome to ADORN, your go-to destination for stylish and high-quality clothing. By accessing or using our website, you agree to comply with and be bound by the following terms and conditions. If you do not agree with any part of these terms, you are prohibited from using the site.</p>
                <ol>
                    <li><strong>Acceptance of Terms:</strong> By using this website and its services, you acknowledge that you have read, understood, and agreed to be bound by these Terms and Conditions, as well as our Privacy Policy. These terms may be updated from time to time, and any changes will be posted on this page.</li>
                    <li><strong>Use of Website:</strong> ADORN is an online platform for purchasing clothing and fashion accessories. You agree to use this website only for lawful purposes and in accordance with applicable laws.</li>
                    <li><strong>Account Registration:</strong> To place an order, customers may need to register for an account and provide accurate personal details. You agree to maintain the confidentiality of your login credentials and are responsible for all activities under your account.</li>
                    <li><strong>Product Availability:</strong> Products listed on ADORN are subject to availability. While we make every effort to update product availability, ADORN does not guarantee the availability of all products at all times. We reserve the right to modify product descriptions, prices, and availability at our discretion without prior notice.</li>
                    <li><strong>Order Process and Payment:</strong> Once an order is placed, you will receive a confirmation email detailing your order. Payment methods accepted include credit cards, debit cards, and other electronic payment systems. All payments are processed securely, and we take reasonable steps to protect your information.</li>
                    <li><strong>Shipping and Delivery:</strong>Our delivery services are available to customers within specified regions. We offer multiple delivery options for your convenience. Delivery times may vary depending on the location. Delivery fees will be calculated during checkout.</li>
                    <li><strong>Returns and Refunds:</strong> We accept returns for unworn, unwashed, and undamaged items within a specified period after delivery. If your order is damaged or incorrect, please contact our customer service within 48 hours for assistance with a possible exchange or refund.</li>
                    <li><strong>Intellectual Property:</strong> All content on ADORN, including product images, logos, text, graphics, and software, are owned by ADORN and protected by copyright laws. Users may not copy, distribute, modify, or republish any content from the website without prior written consent from ADORN.</li>
                    <li><strong>Limitation of Liability:</strong> ADORN will not be held responsible for any damages or losses arising from the use of this website, including but not limited to direct, indirect, incidental, or consequential damages. This includes any issues arising from the use of third-party services such as payment processors and delivery companies.</li>
                    <li><strong>Privacy:</strong> Your privacy is important to us. By using our services, you agree to our Privacy Policy, which outlines how your personal information is collected, used, and protected.</li>
                    <li><strong>Changes to Terms and Conditions:</strong> We reserve the right to modify these Terms and Conditions at any time. Any changes will be posted on this page with the revised date. It is your responsibility to check for updates periodically.</li>
                    <li><strong>Governing Law:</strong> These Terms and Conditions are governed by the laws of the Philippines. Any disputes will be resolved in the competent courts of Quezon City, Philippines.</li>
                    <li><strong>Contact Information:</strong> For any inquiries or concerns, please contact our customer support team at:<br>
                        Email: <a href="mailto:support@adorn.com">support@adorn.com</a><br>
                        Phone: +63 2 1234 5678
                    </li>
                </ol>
            </div>
            <div class="terms-modal-footer">
                <button id="acceptBtn" class="modal-button" onclick="acceptTerms()">Accept</button>
                <button id="declineBtn" class="modal-button" onclick="closeTermsModal()">Decline</button>
            </div>
        </div>
    </div>



    <script src="script.js"></script>
</body>

</html>