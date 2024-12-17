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
$sql = "SELECT first_name, last_name, address, phone_number, email, profile_picture FROM user_info WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header('Location: ../views/login.php');
    exit();
}

$stmt->close();
$conn->close();
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <div class="profile-container">
        <h1 style="text-align: center;">Your Profile</h1>

        <!-- Display Profile Picture -->
        <div style="text-align: center; margin-bottom: 20px;">
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="../uploads/<?php echo ($user['profile_picture']); ?>" alt="Profile Picture" style="width: 150px; height: 150px; border-radius:10%">
            <?php else: ?>
                <img src="../assets/images/default-profile.png" alt="Default Profile Picture" style="width: 150px; height: 150px;">
            <?php endif; ?>
        </div>

        <table style="margin: 0 auto; border-collapse: collapse;">
            <tr>
                <th>First Name:</th>
                <td><?php echo ($user['first_name']); ?></td>
            </tr> 
            <tr>
                <th>Last Name:</th>
                <td><?php echo ($user['last_name']); ?></td>
            </tr>
            <tr>
                <th>Address:</th>
                <td><?php echo ($user['address']); ?></td>
            </tr>
            <tr>
                <th>Phone Number:</th>
                <td><?php echo ($user['phone_number']); ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo ($user['email']); ?></td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 20px;">
            <a href="../views/edit_profile.php" style="text-decoration: none; color: blue; font-size: 16px;">Edit Profile</a>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="../views/dashboard.php" style="text-decoration: none; color: blue;">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
