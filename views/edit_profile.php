<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'form_data');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user data based on the username stored in the session
$username = $_SESSION['username'];
$sql = "SELECT first_name, last_name, address, phone_number, email FROM user_info WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user data
    $user = $result->fetch_assoc();
} else {
    // Redirect to login page if no user data is found
    header('Location: ../views/login.php');
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
    <script>
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
        });

        // Validate the form on submit
        function validateForm(event) {
            event.preventDefault(); // Prevent form submission

            let isValid = true;

            // Firstname Validation
            const firstName = document.getElementById('firstName').value.trim();
            if (!firstName) {
                alert('First name is required');
                isValid = false;
            } else if (!/^[A-Za-z\s]{3,20}$/.test(firstName)) {
                alert('First name must be 3-20 letters only');
                isValid = false;
            }

            // Lastname Validation
            const lastName = document.getElementById('lastName').value.trim();
            if (!lastName) {
                alert('Last name is required');
                isValid = false;
            } else if (!/^[A-Za-z\s]{3,20}$/.test(lastName)) {
                alert('Last name must be 3-20 letters only');
                isValid = false;
            }

            // Address Validation
            const address = document.getElementById('address').value.trim();
            if (!address) {
                alert('Address is required');
                isValid = false;
            } else if (address.length < 5 || address.length > 40) {
                alert('Address must be 5-40 characters');
                isValid = false;
            }

            // Phone Number Validation
            const phoneNumber = document.getElementById('phoneNumber').value.trim();
            if (!phoneNumber) {
                alert('Phone number is required');
                isValid = false;
            } else if (!/^91\d{10}$/.test(phoneNumber)) {
                alert('Phone number must start with 91 and be 12 digits long');
                isValid = false;
            }

            // Email Validation
            const email = document.getElementById('email').value.trim();
            if (!email) {
                alert('Email is required');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Invalid email format');
                isValid = false;
            }

            // Submit the form if all validations pass
            if (isValid) {
                document.getElementById('profileForm').submit();
            }
        }
    </script>
</head>
<body>
    <div class="profile-container">
        <h1 style="text-align: center;">Edit Profile</h1>
        <form id="profileForm" enctype="multipart/form-data" action="../controllers/update_profile.php" method="POST" style="max-width: 600px; margin: 0 auto;" onsubmit="validateForm(event)">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="first_name" value="<?php echo ($user['first_name']); ?>" required>
            
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="last_name" value="<?php echo ($user['last_name']); ?>" required>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo ($user['address']); ?>" required>
            
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" id="phoneNumber" name="phone_number" value="<?php echo ($user['phone_number']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo ($user['email']); ?>" required>

            <label for="profilePicture">Profile Picture:</label>
            <input type="file" id="profilePicture" name="profile_picture" accept="image/*" required>
            
            <div style="text-align: center; margin-top: 20px;">
                <button type="submit" style="padding: 10px 20px; background-color: blue; color: white;">Update Profile</button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="../views/profile.php" style="text-decoration: none; color: blue;">Back to Profile</a>
        </div>
    </div>
<script>
    document.getElementById('profilePicture').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgPreview = document.createElement('img');
                imgPreview.src = e.target.result;
                imgPreview.style.width = '100px';
                imgPreview.style.height = '100px';
                imgPreview.style.marginTop = '10px';

                const previewContainer = document.getElementById('previewContainer');
                previewContainer.innerHTML = ''; // Clear any existing preview
                previewContainer.appendChild(imgPreview);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<div id="previewContainer" style="text-align: center;"></div>
</body>
</html>
