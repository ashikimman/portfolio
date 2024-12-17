<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if the session is not set
    exit();
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="../views/dashboard.php">Home</a></li>
                <li><a href="../views/profile.php">Profile</a></li>
                <li><a href="../assets/js/dashboard.js" id="logout">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header>
                <h1 style="text-align: center;">Welcome to Your Dashboard, <?php echo ($_SESSION['username']); ?>!</h1>
            </header>
           
            <!-- Content Section -->
            <section class="content">
                <h2 style="text-align: center;">Recent Activity</h2>
                <p style="text-align: center;">Here is where your latest activities will appear.</p>
            </section>
        </div>
    </div>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
