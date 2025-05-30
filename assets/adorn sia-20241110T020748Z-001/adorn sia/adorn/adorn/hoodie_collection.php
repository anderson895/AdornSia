<?php include "server.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adorn.</title>
    <link rel="stylesheet" href="Adornhome.css"> 
    <link rel="stylesheet" href="Adornstyle.css">    
    <link rel="icon" type="image/x-icon" href="images/logo1.png">
    
    <!----===== Boxicons CSS ===== -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>

<body>
    <nav>
        <div class="nav">
    <a href="index.html" class="nav-logo-link">
                <img src="images/nav_logo2.png" alt="Navbar Logo" class="nav-logo">
            </a>

            <a href="index.php">Home</a>
            <a href="products.php" class="active">Products</a>
            <a href="whoweare.php">Who we are</a>
            <a href="contactus.php">Contact us</a>
            <div class="icons-container">
                <a href="#" class="nav-icon search">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAAAXNSR0IArs4c6QAAAmJJREFUSEu9lluITlEUx3/DuD0NKSYpd5GQppERkcgtb1IieUOKeOCBmRGTUoiS4omilLyJhHIt4sH9GnmS8ELx4pL91//TNr5z9jnq+/bTuax1fmvtvdZ/nQbqvBrqzKMocBAwDRjpAF8Bt4APZQNOARcBXcCUjA/fAbYBF4uCs4ADgKPA0uhDP4Gnvh8P9IjenQjZrgc+p8DVgEOA28BQO58C9gP3Qjbf/Ky3s1Z2S/zsJdAKfMqDdgc2AteANke7AjibiHoZcAzoF/wuhLNdUAa4GdhnB23nmdQW+f064LCvVwIns/ziDHsCH4H+wHlABVNm3QVaAFXw6CLAmd5O2c4AbpahucBO22cU8Lqaf5zhlnAOe9xb6ruyS2f41U6rgeMp4AFgY4j0UTi7iWVptn8DDAN2uz//+UycoUp/E/AcGPefwBehYMZYLNpTGVa29AvQBPwoCe3lVuobgl4eglb/5mY4B7hsi7nRdVHu4qhnJwEPU0A1/TtgYKjSS6FK5xUl2U7qNBV44hqQFOZmqJcbgIO2WmM9LcLtDEY7bCjlqbRHEqjmv25pk/Fa4EiCqOLYaZsHwOQ8+2ri3WyhHmxHHf5e4D7w3c/6WFW2B6FfGAHeA7OAZ1nQrPE03EI8NnIUTONJk0KlH4+nc8B0y6Kgs6NR9hc7bwBLOVYBW4NqjMiIWANYgn/DhXI11IBmaSY0NfHFkc18/2LoXgL/2ALxtlsgOr8rzlS/H8pUVftnFQEWqdLYZoILT5kqOA0CqdfvVQugvhtn2gHsqjWwAtXIO1TrLc09glptaSa07sBfxqZlHVM1pDsAAAAASUVORK5CYII="/>
                </a>
                <a href="#" class="nav-icon cart">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAAAXNSR0IArs4c6QAAAfRJREFUSEvF1kuozVEUx/HPlcdUIVKuhCIG8ijpShmRx0AZMJDyKiPCAHO3RAwUEWWCksRAGZhg5FkeieRVJGVARBH+S/vo4Nz/4/6PY01Onb1++7vX2mut/e/SYevqMM9/BS7GzBTxB1zE3XZnoDnCw1jXBHiPyXjVTmgeMDhHsfZfAZv3PYQN+IiR6bct3L6KZgruJcJ6HGkLjdwqvYIePMSpmsBHOInveW2xAidqgprly3A2Dzg4q9qXGI5PuNYP+ESMTrrxeFLU+LuwHd8wDi8qQh9k1zEJlzEvtEXAbjzFAAR8ZwXgNNxO/quzAx8vAwyf81iCtxiFryWh+7AptVRcy+eywIW4kCArU7UVMSMjrzECx7CmIShKaeNQzzJhpPcq5hbRsBTnkl/4h+6nlQGG3zbsTpqpuF8APYNogzhoFNsvKwscllpkSDbqDmJjDnBotv4Gg7ADvf0BhiaqbFWJdDZcopXG/PnalI0wNom38noFYIyyKLLfrAowhAswuwT0XTahDmR9+6UuMMbUoqwvb2aVeKsP8PL0/+lW61UiHIjHGJs2mtECugdb0vpebK0T4fQUWWOPVu9k3HHju+gGZtUBhvZSNojn4znmtPjeiVEWIy1sM/bXBYY+Ir2TM1MnJEik/y+rcoclirPYpePAHwJRUh3PcJ1zAAAAAElFTkSuQmCC"/>
                </a>       
                <?php if (!isset($_SESSION['username'])) {
                    echo "<a href='login.php' class='login-btn'>Log In</a>";
                } else {
                    echo "<a href='profile.php' class='login-btn'>"; echo $_SESSION['username']; echo"</a>";
                }
                 ?> 

            </div> 
        </nav>

<div class="main_box">
    <input type="checkbox" id="check">
    <div class="btn_one">
      <label for="check" class="hamburger">
        <i class="fas fa-bars"></i>
      </label>
    </div>
    <div class="sidebar_menu">
      <div class="sidebar_nav">
        <h2> Category </h2>
          </div>
        <div class="btn_two">
          <label for="check">
          </label>
        </div>
      <div class="menu">
      <li>
            <a href="tees_collection.php">Tees</a>
          </li>
          <li>
            <a href="short_collection.php">Shorts</a>
          </li>
          <li>
            <a href="hoodie_collection.php">Hoodies</a>
          </li>
          <li>
            <a href="sweater_collection.php">Sweaters</a>
          </li>
          <li>
            <a href="accesories_collection.php">Accessories</a>
          </li>
          
          </div>
    </div>
  </div>
  </body>

    <!- Footer Section -->
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