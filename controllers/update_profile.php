<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../views/login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'form_data');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Fetch updated data from the form
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$address = trim($_POST['address']);
$phone_number = trim($_POST['phone_number']);
$email = trim($_POST['email']);

// Handle file upload
$profile_picture = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/';
    $file_name = basename($_FILES['profile_picture']['name']);
    $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate file type
    if (in_array($file_extension, $allowed_extensions)) {
        // Create a unique file name
        $new_file_name = $username . '_' . time() . '.' . $file_extension;
        $upload_file_path = $upload_dir . $new_file_name;

        // Move the file to the uploads directory
        if (move_uploaded_file($file_tmp_path, $upload_file_path)) {
            $profile_picture = $new_file_name; // Save the file name to the database
        } else {
            echo "<script>alert('Error uploading the file.'); window.location.href='../views/profile.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid file type. Only JPG, PNG, and GIF are allowed.'); window.location.href='../views/profile.php';</script>";
        exit();
    }
}

// Validate unique email and phone number
$sql = "SELECT username FROM user_info WHERE (email=? OR phone_number=?) AND username != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $email, $phone_number, $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Email or Phone Number already exists. Please choose different ones.'); window.location.href='../views/profile.php';</script>";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Update the user data in the database
$sql = "UPDATE user_info SET first_name=?, last_name=?, address=?, phone_number=?, email=?, profile_picture=? WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssss', $first_name, $last_name, $address, $phone_number, $email, $profile_picture, $username);

if ($stmt->execute()) {
    echo "<script>alert('Profile updated successfully.'); window.location.href='../views/profile.php';</script>";
} else {
    echo "<script>alert('Error updating profile: " . $stmt->error . "'); window.location.href='../views/profile.php';</script>";
}

$stmt->close();
$conn->close();
?>
