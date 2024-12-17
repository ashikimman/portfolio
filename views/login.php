<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Techneat</title>
    <link rel="stylesheet" href= "../assets/css/login.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="../includes/login_process.php" method="post">
            <img class="image1" src="../assets/images/logonew.png" alt="Techneat new logo">
           
            <input type="text" placeholder="Enter your username" id="username" name="username" required>
            <input type="password" placeholder="Enter your password" id="password" name="password" class="passwordbox" required>
            <button type="submit">Login</button>

            <p>Still not yet signed in?<a style="margin-left: 10px;" href="index.html">Sign up</a></p>
        </form>
        <div class="error-message">
            <?php if (!empty($error)): ?>
                <p><?php echo ($error); ?></p>
            <?php endif; ?>
        </div>
    </div>
    
<script src="../assets/js/login.js"></script>
</body>
</html>