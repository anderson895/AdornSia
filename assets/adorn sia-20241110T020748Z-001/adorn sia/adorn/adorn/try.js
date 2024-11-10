/*--- menu on mobile ---*/

function openNav() {
    document.getElementById("myNav").style.height = "100%";
    document.getElementById("main").style.display = "none";
}

function closeNav() {
    document.getElementById("myNav").style.height = "0%";
    document.getElementById("main").style.display = "block";
}


/*--- dropdown menu on navbar ---*/

var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}


/*--- change navbar color to white on scroll ---*/

const nav = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        nav.classList.add('navbar-scrolled');
    } else if (window.scrollY < 100) {
        nav.classList.remove('navbar-scrolled');
    }
});


/*--- view product ---*/

function openTab(tabName) {
    var i, x;
    x = document.getElementsByClassName("view-product-cont");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(tabName).classList.add("slide-down");
    document.getElementById(tabName).style.display = "block";
}

function closeTab(tabName) {
    var tabToClose = document.getElementById(tabName);

    // Add slide-up class to the tab to trigger the slide-up animation
    tabToClose.classList.add("slide-up");

    // Wait for the animation to finish, then remove the tab from the DOM
    tabToClose.addEventListener("animationend", function() {
        tabToClose.remove();
    });
}


/*--- tabbed image ---*/

function myFunction(img, id) {
    var expandImg = document.getElementById(id);
    expandImg.src = img.src;
    expandImg.parentElement.style.display = "block";
}


/*--- search pop up ---*/
$(document).ready(function(){
	$('a[href="#search"]').on('click', function(event) {                    
		$('#search').addClass('open');
		$('#search > form > input[type="search"]').focus();
	});            
	$('#search, #search button.close').on('click keyup', function(event) {
		if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
			$(this).removeClass('open');
		}
	});            
});


/*--- open product category ---*/

window.onload = function() {
    // Get the URL parameter
    var urlParams = new URLSearchParams(window.location.search);
    var targetId = urlParams.get('id');

    // Hide all div elements
    var divElements = document.getElementsByClassName("products");
    for (var i = 0; i < divElements.length; i++) {
        divElements[i].style.display = "none";
    }

    // Show the specific div element based on the URL parameter
    var targetDiv = document.getElementById(targetId);
    if (targetDiv) {
        targetDiv.style.display = "block";
    }
};