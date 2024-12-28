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

$vehicleID = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $Vehicle_Model = isset($_POST['Vehicle_model']) ? $mysqli->real_escape_string($_POST['Vehicle_model']) : null;
    $Vehicle_Name = isset($_POST['Vehicle_name']) ? $mysqli->real_escape_string($_POST['Vehicle_name']) : null;
    $Lease_ID = isset($_POST['Lease_ID']) ? intval($_POST['Lease_ID']) : null;

    // Validate required fields
    if (!empty($Vehicle_Model) && !empty($Vehicle_Name) && !empty($Lease_ID)) {
        // Prepare the SQL statement for inserting data
        $query = "INSERT INTO Vehicle (Vehicle_model, Vehicle_name, Lease_ID) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ssi", $Vehicle_Model, $Vehicle_Name, $Lease_ID);

        if ($stmt->execute()) {
            // Get the generated Vehicle_ID
            $vehicleID = $stmt->insert_id;
            echo "Vehicle created successfully. Your Vehicle_ID is: " . $vehicleID;
        } else {
            echo "Error inserting vehicle: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: All fields are required.";
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
