<?php include "server.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adorn</title>
    <link rel="stylesheet" href="Adornhome.css"> 
    <link rel="stylesheet" href="Adornstyle.css">
    <link rel="icon" type="image/x-icon" href="images/logo1.png">

    
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
<div class="nav">
    <input type="checkbox" id="sidebar-active">
    <label for="sidebar-active" class="open-sidebar-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32">
            <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
        </svg>
    </label>
    <label id="overlay" for="sidebar-active"></label>
    <div class="links-container">
        <label for="sidebar-active" class="close-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32">
                <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
            </svg>
        </label>
        <a href="index.php" class="nav-logo-link">
            <img src="images/nav_logo2.png" alt="Navbar Logo" class="nav-logo">
        </a>
        <a href="index.php" class="active">Home</a>
        <a href="products.php">Products</a>
        <a href="whoweare.php">Who we are</a>
        <a href="contactus.php">Contact us</a>
        <div class="icons-container">
            <a href="#" class="nav-icon search">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAAAXNSR0IArs4c6QAAAmJJREFUSEu9lluITlEUx3/DuD0NKSYpd5GQppERkcgtb1IieUOKeOCBmRGTUoiS4omilLyJhHIt4sH9GnmS8ELx4pL91//TNr5z9jnq+/bTuax1fmvtvdZ/nQbqvBrqzKMocBAwDRjpAF8Bt4APZQNOARcBXcCUjA/fAbYBF4uCs4ADgKPA0uhDP4Gnvh8P9IjenQjZrgc+p8DVgEOA28BQO58C9gP3Qjbf/Ky3s1Z2S/zsJdAKfMqDdgc2AteANke7AjibiHoZcAzoF/wuhLNdUAa4GdhnB23nmdQW+f064LCvVwIns/ziDHsCH4H+wHlABVNm3QVaAFXw6CLAmd5O2c4AbpahncBO22cU8Lqaf5zhlnAOe9xb6ruyS2f41U6rgeMp4AFgY4j0UTi7iWVptn8DDAN2uz//+UycoUp/E/AcGPefwBehYMZYLNpTGVa29AvQBPwoCe3lVuobgl4eglb/5mY4B7hsi7nRdVHu4qhnJwEPU0A1/TtgYKjSS6FK5xUl2U7qNBV44hqQFOZmqJcbgIO2WmM9LcLtDEY7bCjlqbRHEqjmv25pk/Fa4EiCqOLYaZsHwOQ8+2ri3WyhHmxHHf5e4D7w3c/6WFW2B6FfGAHeA7OAZ1nQrPE03EI8NnIUTONJk0KlH4+nc8B0y6Kgs6NR9hc7bwBLOVYBW4NqjMiIWANYgn/DhXI11ABmaSY0NfHFkc18/2LoXgL/2ALxtlsgOr8rzlS/H8pUVftnFQEWqdLYZoILT5kqOA0CqdfvVQugvhtn2gHsqjWwAtXIO1TrLc09glptaSa07sBfxqZlHVM1pDsAAAAASUVORK5CYII=" />
            </a>
            <a href="#" class="nav-icon cart">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAAAXNSR0IArs4c6QAAAfRJREFUSEvF1kuozVEUx/HPlcdUIVKuhCIG8ijpShmRx0AZMJDyKiPCAHO3RAwUEWWCksRAGZhg5FkeieRVJGVARBH+S/vo4Nz/4/6PY01Onb1++7vX2mut/e/SYevqMM9/BS7GzBTxB1zE3XZnoDnCw1jXBHiPyXjVTmgeMDhHsfZfAZv3PYQN+IiR6bct3L6KZgruJcJ6HGkLjdwqvYIePMSpmsBHOInveW2xAidqgprly3A2Dzg4q9qXGI5PuNYP+ESMTrrxeFLU+LuwHd8wDi8qQh9k1zEJlzEvtEXAbjzFAAR8ZwXgNNxO/quzAx8vAwyf81iCtxiFryWh+7AptVRcy+eywIW4kCArU7UVMSMjrzECx7CmIShKaeNQzzJhpPcq5hbRsBTnkl/4h+6nlQGG3zbsTpqpuF8APYNogzhoFNsvKwscllpkSDbqDmJjDnBotv4Gg7ADvf0BhiaqbFWJdDZcopXG/PnalI0wNom38noFYIyyKLLfrAowhAswuwT0XTahDmR9+6UuMMbUoqwvb2aVeKsP8PL0/+lW61UiHIjHGJs2mtECugdb0vpebK0T4fQUWWOPVu9k3HHju+gGZtUBhvZSNojn4znmtPjeiVEWIy1sM/bXBYY+Ir2TM1MnJEik/y+rcoclirPYpePAHwJRUh3PcJ1zAAAAAElFTkSuQmCC" />
                <<div class="dropdown">
    <?php if (!isset($_SESSION['username'])) {
        echo "<a href='login.php' class='login-btn'>Log In</a>";
    } else {
        echo "<a href='#' class='login-btn'>" . htmlspecialchars($_SESSION['username']) . " <i class='arrow down'></i></a>";
        echo "<div class='dropdown-content'>";
        echo "<a href='profile.php'>View Profile</a>";
        echo "<a href='" . $_SERVER['PHP_SELF'] . "?logout=true' class='logout-btn'>Logout</a>";
        echo "</div>";

        // Handle the logout
        if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
            session_start(); // Start or resume the session
            session_destroy(); // Destroy the session to log out
            header("Location: index.php"); // Redirect to index or login page
            exit(); // Prevent further script execution
        }
    }
    ?>
</div>
        </div>
    </div>
</div>

    <!--end of navbar-->

    <section class="company-info">
        <div class="logo-text">
            <img src="images/logo1.png" alt="Company Logo" class="company-logo">
            <h1 class="company-name">ADORN</h1>
        </div>
        <p class="company-description">
        Style That Speaks;Every piece you wear tells a story. Adorn yourself with styles that reflect your personality and make bold statements.

        </p>
        <a href="products.php" class="shop-now-button">Shop Now</a>
    </section>

    <!-- Best Sellers Section -->
    <section class="best-sellers">
        <h2>Our <i>Best </i> Sellers</h2>
        <div class="best-seller-items">
            <div class="best-seller">
                <a href="#drink1">
                    <img src="images/lffp.png" alt="Drink 1" class="drink-image">
                    <p class="drink-name">LLFPT HOODIE</p>
                </a>
            </div>
            <div class="best-seller">
                <a href="#drink2">
                    <img src="images/lvsz.png" alt="Drink 2" class="drink-image">
                    <p class="drink-name">LVZ HOODIE </p>
                </a>
            </div>
            <div class="best-seller">
                <a href="#drink3">
                    <img src="images/fragile.png" alt="Drink 3" class="drink-image">
                    <p class="drink-name">FRAGILE HOODIE
                    </p>
                </a>
            </div>
            <div class="best-seller">
                <a href="#drink4">
                    <img src="images/cloud.png" alt="Drink 4" class="drink-image">
                    <p class="drink-name">NOIR HOODIE
                    </p>
                </a>
            </div>
            <div class="best-seller">
                <a href="#drink5">
                    <img src="images/noir.png" alt="Drink 5" class="drink-image">
                    <p class="drink-name">NOIR HOODIE</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Discover Our Selection Section -->
    <section class="discover-selection">
        <h2>Discover <span class="font1">Our</span> Selection</h2>
        <div class="selection-container">
            <div class="selection-items">
                <div class="selection-item">
                    <img src="images/teeS.png" alt="Collection 1">
                    <p>TEES</p>
                    <a href="tees_collection.php" class="selection-btn">Shop Now</a>
                </div>
                <div class="selection-item">
                    <img src="images/HoodieS.png" alt="Collection 2">
                    <p>HOODIES</p>
                    <a href="hoodie_collection.php" class="selection-btn">Shop Now</a>
                </div>
                <div class="selection-item">
                    <img src="images/shortS.png" alt="Collection 3">
                    <p>SHORTS</p>
                    <a href="short_collection.php" class="selection-btn">Shop Now</a>
                </div>
                <div class="selection-item">
                    <img src="images/sweatS.png" alt="Collection 4">
                    <p>PULLOVER</p>
                    <a href="sweater_collection.php" class="selection-btn">Shop Now</a>
                </div>
                <div class="selection-item">
                    <img src="images/accesorieS.png" alt="Collection 5">
                    <p>ACCESORIES</p>
                    <a href="accesories_collection.php" class="selection-btn">Shop Now</a>
                </div>
                <div class="selection-item">
                    <img src="images/ALLP.png" alt="Collection 6">
                    <p>ALL</p>
                    <a href="products.php" class="selection-btn">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

    <section class="customer-testimonials">
        <h2>Customer Testimonials</h2> 
        <p class="testimonial-intro">Read what our customers say</p>
        <div class="testimonial-container">
            <div class="testimonial-item">
                <p class="quote">"</p>
                <blockquote>"Adorn has become my go-to for all my wardrobe needs! The selection is incredible, and I love the personalized styling recommendations. My orders always arrive quickly and beautifully packaged."</blockquote>
                <p class="customer-name">- Renzo A., Quezon City</p>
            </div>
            <div class="testimonial-item">
                <p class="quote">"</p>
                <blockquote>""I was impressed with how easy it was to find the perfect outfit for my event. The website is intuitive, and the checkout process was seamless. I’ll definitely be back for my next wardrobe update!""</blockquote>
                <p class="customer-name">- Arshad N., Makati</p>
            </div>
            <div class="testimonial-item">
                <p class="quote">"</p>
                <blockquote>"Fantastic service! The variety of clothing styles is top-notch, from casual wear to elegant outfits. I appreciate the attention to detail, especially in the quality of the fabrics and the packaging. Highly recommend Adorn!"</blockquote>
                <p class="customer-name">- Reymark C., Taguig</p>
            </div>
            <div class="testimonial-item">
                <p class="quote">"</p>
                <blockquote>"Adorn never disappoints! From browsing the website to receiving my order, the experience is seamless. Their customer service is excellent, and the curated collection always has something stylish and new to discover!"</blockquote>
                <p class="customer-name">- Justine H., Pasig</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">

            <div class="footer-column">
                <img src="images/footer_logo2.png" alt="Logo" class="footer-logo">
                <p>© 2024 Adorn, All rights reserved.</p>
            </div>

            <div class="footer-column">
                <h3>Company</h3>
                <a href="whoweare.php#about-us">About Us</a>
                <a href="whoweare.php#our-vision">Our Vision</a>
                <a href="whoweare.php#our-mission">Our Mission</a>
            </div>

            <div class="footer-column">
                <h3>Resources</h3>
                <a href="#faq">FAQ</a>
                <a href="#shipping-info">Shipping Info</a>
                <a href="#returns">Returns</a>
            </div>

            <div class="footer-column">
                <h3>Connect</h3>
                <a href="#instagram">Instagram</a>
                <a href="#facebook">Facebook</a>
                <a href="mailto:email@example.com">Email</a>
            </div>
        </div>
    </footer>





    <script src="home.js"></script>
</body>

</html>