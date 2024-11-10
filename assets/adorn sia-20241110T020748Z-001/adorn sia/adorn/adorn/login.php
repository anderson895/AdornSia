<?php include "server.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="Adornstyle.css">
    <link rel="icon" type="image/x-icon" href="images/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome -->

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Onest', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* Prevents scrolling */
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('images/BG2.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: blur(5px);
            z-index: -1;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.80);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 28px;
            text-transform: uppercase;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: calc(100% - 20px);
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: rgba(236, 236, 236, 0.8);
            /* Light background for inputs */
            font-size: 16px;
            transition: background 0.3s ease;
            position: relative;
            /* Position relative for button positioning */
        }

        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            background: rgba(255, 255, 255, 1);
            /* White background on focus */
            outline: none;
        }

        .password-container,
        .username-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        .password-container input {
            width: 100%;
            padding-right: 50px; /* Add some padding to prevent text from overlapping the button */
        }

        .password-container button {
            position: absolute;
            right: 10px; /* Position the button inside the input */
            background-color: transparent;
            border: none;
            color: #ff6f00;
            cursor: pointer;
            font-size: 18px; /* Adjust the icon size */
            padding: 0;
            line-height: 1;
        }

        .toggle-password i {
            font-size: 12px; 
            cursor: pointer;
            color: gray;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 35%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            color: #E85C0D;
            font-size: 16px;
            padding: 0;
            line-height: 1;
        }

        .remember-me {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Space between checkbox and forgot password link */
    margin-bottom: 30px;
}

.remember-me input[type="checkbox"] {
    margin-right: 10px;
}

.login-form button[type="submit"] {
    width: 40%;
    padding: 12px;
    background-color: #000000; /* Black button color */
    color: #fff; /* White text */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, color 0.3s ease; /* Added transition for text color */
    margin-bottom: 20px;
}

.login-form button[type="submit"]:hover {
    background-color: #ffffff; /* White background on hover */
    color: #000000; /* Black text on hover */
}

.login-form a {
    text-decoration: none;
    color: #000000; /* Change link color to black */
    font-size: 14px;
}

.forgot-password {
    font-size: 12px;
    margin-top: 0;
    color: light gray; /* Change to a standard light gray */
}


.footer-text {
    text-align: center;
    margin-top: 20px;
    color: #000; /* Footer text color */
    font-size: 14px;
}

.footer-text a {
    color: White; /* Footer link color */
    text-decoration: none;
    font-weight: 700;
    font-family: 'Onest', sans-serif;
}
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Log In</h2>
            <form action="login.php" method="post">
                <div class="username-container">
                    <input type="text" id="username" name="user" placeholder="Username" required value="<?php echo $userInput; ?>">
                </div>
                <div class="password-container">
                    <input type="password" id="password" name="pw" placeholder="Password" required>
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                <div class="remember-me">
                    <div>
                        <input type="checkbox" id="rememberMe">
                        <label for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a> <!-- Forgot password link -->
                </div>
                <button type="submit" name="login">LOGIN</button>
                <?php if ($formSubmitted && $errorMessage != ''): ?>
                <p class="message" id="loginMessage" style="color: red;"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
            </form>

            <div class="footer-text">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>