<?php
session_start();

// Include database configuration
require 'db_config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create database connection using constants from db_config.php
    $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Get user inputs from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user info from the database
    $stmt = $db->prepare("SELECT PasswordHash FROM UserManagement WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password using SHA-256 hashing
        if (hash('sha256', $password) === $hashed_password) { // Using SHA-256 for verification
            $_SESSION['username'] = $username;  // Start user session
            header("Location: maintenance.php"); // Redirect to maintenance page
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "<p style='color:red;'>Invalid credentials!</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid credentials!</p>";
    }

    // Clean up
    $stmt->close(); // Close statement
    $db->close(); // Close database connection
} else {
    // Redirect to login page if accessed directly
    header("Location: login.html");
    exit();
}
?>