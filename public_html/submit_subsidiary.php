<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the db_config.php file for connection details
require 'db_config.php'; // Ensure the file is correctly located

// Create a new MySQLi connection using the constants from db_config.php
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check for connection errors
if ($mysqli->connect_errno) {
    die("Connection failed: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$subsidiaryID = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $Subsidiary_Name = isset($_POST['subsidiary_name']) ? $mysqli->real_escape_string($_POST['subsidiary_name']) : null;
    $Location = isset($_POST['location']) ? $mysqli->real_escape_string($_POST['location']) : null;
    $Workforce_Size = isset($_POST['workforce_size']) ? intval($_POST['workforce_size']) : null;

    // Validate required fields
    if (!empty($Subsidiary_Name) && !empty($Location) && !empty($Workforce_Size)) {
        // Prepare the SQL statement for inserting data
        $query = "INSERT INTO Subsidiaries (Subsidiary_Name, Location, Workforce_Size) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ssi", $Subsidiary_Name, $Location, $Workforce_Size);

        if ($stmt->execute()) {
            // Get the generated Subsidiary_ID
            $subsidiaryID = $stmt->insert_id;
            echo "Subsidiary created successfully. Your Subsidiary_ID is: " . $subsidiaryID;
        } else {
            echo "Error inserting subsidiary: " . $stmt->error;
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
