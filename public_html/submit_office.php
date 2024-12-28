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

$officeID = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $Office_Name = isset($_POST['office_name']) ? $mysqli->real_escape_string($_POST['office_name']) : null;
    $Office_Location = isset($_POST['office_location']) ? $mysqli->real_escape_string($_POST['office_location']) : null;
    $Lease_ID = isset($_POST['Lease_ID']) ? intval($_POST['Lease_ID']) : null;

    // Validate required fields
    if (!empty($Office_Name) && !empty($Office_Location) && !empty($Lease_ID)) {
        // Prepare the SQL statement for inserting data
        $query = "INSERT INTO Office (Office_Name, Office_Location, Lease_ID) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ssi", $Office_Name, $Office_Location, $Lease_ID);

        if ($stmt->execute()) {
            // Get the generated Office_ID
            $officeID = $stmt->insert_id;
            echo "Office created successfully. Your Office_ID is: " . $officeID;
        } else {
            echo "Error inserting office: " . $stmt->error;
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
