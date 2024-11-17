 // Toggle dropdown visibility on button click
 document.getElementById('profileButton').addEventListener('click', function() {
    var dropdownMenu = this.nextElementSibling;
    // Toggle display and opacity
    if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
      dropdownMenu.style.display = "block";
      dropdownMenu.style.opacity = 1;
      dropdownMenu.style.pointerEvents = "auto";
    } else {
      dropdownMenu.style.display = "none";
      dropdownMenu.style.opacity = 0;
      dropdownMenu.style.pointerEvents = "none";
    }
  });

  // Close dropdown if clicked outside of the button or menu
  window.addEventListener('click', function(event) {
    var dropdown = document.querySelector('.dropdown');
    if (!dropdown.contains(event.target)) {
      var dropdownMenu = dropdown.querySelector('.dropdown-menu');
      dropdownMenu.style.display = "none";
      dropdownMenu.style.opacity = 0;
      dropdownMenu.style.pointerEvents = "none";
    }
  });