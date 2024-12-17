<?php
    session_start();

    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Prevent caching of the logout confirmation page
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Redirect to the login page
    header('Location: ../views/login.php');
    
    exit();
?>
<a href="#" onclick="confirmLogout()">Logout</a>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "../views/login.php";
    }
}
</script>