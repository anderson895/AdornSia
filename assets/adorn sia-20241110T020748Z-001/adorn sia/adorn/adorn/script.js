// Function to validate form and ensure terms and conditions checkbox is checked
function validateForm() {
    var terms = document.getElementById("terms");
    if (!terms.checked) {
        alert("Please agree to the Terms and Conditions before signing up.");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

// Function to show the form and hide the age verification modal
function verifyAge(isOldEnough) {
    if (isOldEnough) {
        document.querySelector('.modal').style.display = 'none';
        document.querySelector('.container').style.display = 'flex';
    } else {
        alert('You must be 18 years or older to access this page.');
        window.location.href = 'https://www.example.com';
    }
}

// Show the age verification modal on page load
window.onload = () => {
    document.querySelector('.modal').style.display = 'flex';
};

// Function to toggle password visibility
function togglePasswordVisibility(inputId, button) {
    const passwordInput = document.getElementById(inputId);
    const isPasswordVisible = passwordInput.type === 'text';
    
    // Toggle the input type
    passwordInput.type = isPasswordVisible ? 'password' : 'text';
    
    // Toggle between eye and eye-slash icon
    const icon = button.querySelector('i');
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}

const today = new Date().toISOString().split('T')[0];

// Set the max attribute of the date input field to today's date
document.getElementById('bday').setAttribute('max', today);

function verification() {
    // Hide the .info section
    document.getElementById('info-section').style.display = 'none';

    // Show the .verify section
    document.getElementById('verify-section').style.display = 'block';
}

function enterID() {
    const idType = document.getElementById("idType").value;
    const idNumberInput = document.getElementById("idNumber");
    const idLabel = document.getElementById("idLabel");
    let pattern, placeholder;

    switch (idType) {
        case "National ID":
            pattern = "\\d{4}-\\d{4}-\\d{4}-\\d{4}"; // 16 digits, divided by dashes
            placeholder = "1234-5678-9012-3456";
            break;
        case "Passport":
            pattern = "[A-Z]{2}\\d{7}"; // 2 letters followed by 7 digits
            placeholder = "AB1234567";
            break;
        case "Driver's License":
            pattern = "[A-Z]{3}\\d{9}"; // 3 letters followed by 9 digits
            placeholder = "ABC123456789";
            break;
        case "SSS ID":
            pattern = "\\d{2}-\\d{7}-\\d{1}"; // 10 digits, divided by dashes
            placeholder = "01-2345678-9";
            break;
        case "UMID":
            pattern = "\\d{4}-\\d{4}-\\d{4}"; // 12 digits, divided by dashes
            placeholder = "1234-5678-9012";
            break;
        case "Postal ID":
            pattern = "[A-Z]{2}\\d{6}"; // 2 letters followed by 6 digits
            placeholder = "AB123456";
            break;
        case "PRC ID":
            pattern = "[A-Z]{4}\\d{7}"; // 4 letters followed by 7 digits
            placeholder = "ABCD1234567";
            break;
        case "Pag-Ibig Loyalty Plus":
            pattern = "\\d{4}-\\d{4}-\\d{4}"; // 12 digits, divided by dashes
            placeholder = "1234-5678-9012";
            break;
        default:
            pattern = "";
            placeholder = "";
    }

    idNumberInput.setAttribute("pattern", pattern);
    idNumberInput.setAttribute("placeholder", placeholder);
    idNumberInput.style.display = "block";
    idLabel.style.display = "block";
}

document.querySelector('.id-type').addEventListener('click', function() {
    document.querySelector('.select-id-type').classList.toggle('open');
});

document.querySelectorAll('.option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelector('.id-type span').textContent = option.textContent;
        document.querySelector('.select-id-type').classList.remove('open');
    });
});

// Function to open Terms and Conditions modal
function openTermsModal() {
    document.getElementById("termsModal").style.display = "block"; // Show the modal
}

// Function to close Terms and Conditions modal
function closeTermsModal() {
    document.getElementById("termsModal").style.display = "none"; // Hide the modal
}

function acceptTerms() {
    document.getElementById("terms").checked = true; // Check the checkbox
    document.getElementById("termsModal").style.display = "none";
}