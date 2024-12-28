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
    $Apartment_Name = isset($_POST['Apartment_Name']) ? $mysqli->real_escape_string($_POST['Apartment_Name']) : null;
    $Apartment_Location = isset($_POST['Apartment_Location']) ? $mysqli->real_escape_string($_POST['Apartment_Location']) : null;
    $Lease_ID = isset($_POST['Lease_ID']) ? intval($_POST['Lease_ID']) : null;

    // Validate required fields
    if (!empty($Apartment_Name) && !empty($Apartment_Location) && !empty($Lease_ID)) {
        // Prepare the SQL statement for inserting data into the Apartment table
        $query = "INSERT INTO Apartment (Apartment_Name, Apartment_Location, Lease_ID) VALUES (?, ?, ?)";

        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ssi", $Apartment_Name, $Apartment_Location, $Lease_ID);

        if ($stmt->execute()) {
            // Success message
            echo "Apartment record created successfully!";
        } else {
            // Error message
            echo "Error inserting apartment: " . $stmt->error;
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
