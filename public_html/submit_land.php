<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the db_config.php file for connection details
require 'db_config.php'; // Ensure the file is correctly located

// Create a new MySQLi connection using the constants from db_config.php
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $Land_Name = isset($_POST['Land_Name']) ? $mysqli->real_escape_string($_POST['Land_Name']) : null;
    $Land_Size = isset($_POST['Land_Size']) ? $_POST['Land_Size'] : null;
    $Lease_ID = isset($_POST['Lease_ID']) ? intval($_POST['Lease_ID']) : null;

    // Validate required fields
    if (!empty($Land_Name) && !empty($Land_Size) && !empty($Lease_ID)) {
        // Prepare the SQL statement for inserting data into the Land table
        $query = "INSERT INTO Land (Land_Name, Land_Size, Lease_ID) VALUES (?, ?, ?)";
        
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("sdi", $Land_Name, $Land_Size, $Lease_ID);

        if ($stmt->execute()) {
            // Success message
            echo "Land record created successfully!";
        } else {
            // Error message
            echo "Error inserting land: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Validation error
        echo "Error: All required fields must be filled.";
    }
}

// Close the MySQL connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<body>
    <a href="maintenance.html">Go Back to Maintenance Page</a>
</body>
</html>
