// Restrict inputs in real-time
document.addEventListener('DOMContentLoaded', function () {
    // Restrict Firstname and Lastname
    document.getElementById('firstName').addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-z\s]/g, '').substring(0, 20); // Only letters and spaces, max 20 chars
    });

    document.getElementById('lastName').addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-z\s]/g, '').substring(0, 20); // Only letters and spaces, max 20 chars
    });

    // Restrict Address
    document.getElementById('address').addEventListener('input', function () {
        this.value = this.value.substring(0, 40); // Max 40 characters
    });

    // Restrict Phone Number
    document.getElementById('phoneNumber').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 12); // Only numbers, max 12 digits
        if (!this.value.startsWith('91')) {
            this.value = '91' + this.value.replace(/^91/, ''); // Force '91' at the start
        }
    });

    // Restrict Username
    document.getElementById('username').addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-z0-9]/g, '').substring(0, 20); // Only alphanumeric, max 20 chars
    });
});

// Validate the form on submit
document.getElementById('myForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission

    // Clear previous error messages
    const errors = document.querySelectorAll('.error-message');
    errors.forEach(error => error.textContent = '');

    const formError = document.getElementById('formError');
    formError.style.display = 'none';
    formError.textContent = '';

    let isValid = true;

    // Firstname Validation
    const firstName = document.getElementById('firstName').value.trim();
    if (!firstName) {
        displayError('firstNameError', 'First name is required');
        isValid = false;
    } else if (!/^[A-Za-z\s]{3,20}$/.test(firstName)) {
        displayError('firstNameError', 'First name must be 3-20 letters only');
        isValid = false;
    }

    // Lastname Validation
    const lastName = document.getElementById('lastName').value.trim();
    if (!lastName) {
        displayError('lastNameError', 'Last name is required');
        isValid = false;
    } else if (!/^[A-Za-z\s]{3,20}$/.test(lastName)) {
        displayError('lastNameError', 'Last name must be 3-20 letters only');
        isValid = false;
    }

    // Address Validation
    const address = document.getElementById('address').value.trim();
    if (!address) {
        displayError('addressError', 'Address is required');
        isValid = false;
    } else if (address.length < 5 || address.length > 40) {
        displayError('addressError', 'Address must be 5-40 characters');
        isValid = false;
    }

    // Phone Number Validation
    const phoneNumber = document.getElementById('phoneNumber').value.trim();
    if (!phoneNumber) {
        displayError('phoneNumberError', 'Phone number is required');
        isValid = false;
    } else if (!/^91\d{10}$/.test(phoneNumber)) {
        displayError('phoneNumberError', 'Phone number must start with 91 and be 12 digits long');
        isValid = false;
    }

    // Email Validation
    const email = document.getElementById('email').value.trim();
    if (!email) {
        displayError('emailError', 'Email is required');
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        displayError('emailError', 'Invalid email format');
        isValid = false;
    }

    // Username Validation
    const username = document.getElementById('username').value.trim();
    if (!username) {
        displayError('usernameError', 'Username is required');
        isValid = false;
    } else if (!/^[A-Za-z0-9]{4,20}$/.test(username)) {
        displayError('usernameError', 'Username must be 4-20 alphanumeric characters');
        isValid = false;
    }

    // Password Validation
    const password = document.getElementById('password').value;
    const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!password) {
        displayError('passwordError', 'Password is required');
        isValid = false;
    } else if (!strongPasswordRegex.test(password)) {
        displayError('passwordError', 'Password must be at least 8 characters, include uppercase, lowercase, number, and special character');
        isValid = false;
    }

    // Confirm Password Validation
    const confirmPassword = document.getElementById('confirmPassword').value;
    if (!confirmPassword) {
        displayError('confirmPasswordError', 'Confirm password is required');
        isValid = false;
    } else if (password !== confirmPassword) {
        displayError('confirmPasswordError', 'Passwords do not match');
        isValid = false;
    }

    // Submit the form if all validations pass
    if (isValid) {
        this.submit();
    }
});

// Function to display error messages
function displayError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
    errorElement.style.display = 'inline';
}
function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const passwordToggle = passwordField.nextElementSibling; // The eye icon
    if (passwordField.type === "password") {
        passwordField.type = "text";
       // Change icon to "hidden" state
    } else {
        passwordField.type = "password";
        // passwordToggle.textContent = "👁️"; // Change back to "visible" state
    }
}