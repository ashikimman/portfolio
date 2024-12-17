document.getElementById('logout').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the default link behavior

    // Invalidate the session (example using localStorage for demo purposes)
    if (confirm("Are you sure you want to logout?")) {
        // Clear session data (adjust based on your backend setup)
        localStorage.removeItem('PHPSESSID'); // Example if using token-based auth
        sessionStorage.clear(); // Example for session-based storage
        // Cookies.removeItem('PHPSESSID');
        window.location.href = '../controllers/logout.php'; // Update with your actual login page path
    }
});
