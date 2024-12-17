<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'form_data');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM user_info WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username; // Start the session
            header('Location: ../views/dashboard.php'); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "No user found.";
    }

    $stmt->close();
    $conn->close();
}
include('../views/login.php'); // Include the login form with $error
?>
