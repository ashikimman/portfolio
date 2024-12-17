document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    // Example: Check if credentials are correct (replace with actual backend call)
    const isAuthenticated = await authenticateUser(username, password);

    if (isAuthenticated) {
        // Set sessionStorage indicating the user is logged in
        sessionStorage.setItem('isLoggedIn', 'true');
        sessionStorage.setItem('username', username);  // Optionally, store the username for personalization
        window.location.href = '/dashboard.php';  // Redirect to dashboard
    } else {
        alert("Invalid credentials");
    }
});

// Simulated authentication check (replace with actual API call)
async function authenticateUser(username, password) {
    // Mockup check for username and password (replace with real API check)
    if (username === "user" && password === "password123") {
        return true;
    }
    return false;
}
