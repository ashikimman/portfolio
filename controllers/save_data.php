<?php
$errorMessages = []; // Array to store error messages

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $address = trim($_POST["address"]);
    $phoneNumber = trim($_POST["phoneNumber"]);
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"]; 
    
    // Proceed only if no validation errors
    if (empty($errorMessages)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Database connection
        $conn = new mysqli("localhost", "root", "", "form_data");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the phone number, email, or username already exists
        $query = "SELECT username, email, phone_number FROM user_info WHERE username = ? OR email = ? OR phone_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['email'] === $email) {
                    $errorMessages[] = "Email already exists. Please use a different one.";
                }
                if ($row['phone_number'] === $phoneNumber) {
                    $errorMessages[] = "Phone number already exists. Please use a different one.";
                }
                if ($row['username'] === $username) {
                   $errorMessages[] = "Username already exists. Please choose a different one.";
                }
            }
        } else {
            // Use a prepared statement to insert new user
            $query = "INSERT INTO user_info (first_name, last_name, address, phone_number, email, username, password) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sssssss", $firstName, $lastName, $address, $phoneNumber, $email, $username, $hashedPassword);
                if ($stmt->execute()) {
                    // Redirect to a success page
                    header("Location: ../views/success.html");
                    exit();
                } else {
                    $errorMessages[] = "Error: " . $stmt->error;
                }
            } else {
                $errorMessages[] = "Error preparing statement: " . $conn->error;
            }
        }

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();
    }
}

// Display error messages as an alert
if (!empty($errorMessages)) {
    echo "<script>
    alert('" . implode("\\n", $errorMessages) . "');
    window.location.href = '../views/index.html'; 
    </script>";
}
?>
