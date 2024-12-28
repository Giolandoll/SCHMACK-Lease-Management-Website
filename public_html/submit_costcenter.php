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
    die("MySQL Connection failed: " . $mysqli->connect_error);
}

$costCenterID = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $CostCenter_Name = isset($_POST["CostCenter_Name"]) ? $_POST["CostCenter_Name"] : null;
    $Budget = isset($_POST["Budget"]) ? $_POST["Budget"] : null;

    // Check if all required fields are provided
    if (!empty($CostCenter_Name) && !empty($Budget)) {
        // Prepare the SQL query to insert data
        $query = "INSERT INTO CostCenter (CostCenter_Name, Budget) VALUES (?, ?)";
        $stmt = $mysqli->prepare($query);

        // Check if the statement preparation was successful
        if ($stmt === false) {
            echo "Cost Center Preparation Error: " . $mysqli->error;
        } else {
            // Bind the parameters and execute the statement
            $stmt->bind_param("sd", $CostCenter_Name, $Budget);

            if ($stmt->execute()) {
                // Retrieve the newly generated CostCenter_ID
                $costCenterID = $stmt->insert_id;
                echo "Successful Insertion! Your CostCenter_ID is: ". $costCenterID;
            } else {
                echo "Cost Center Insertion Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    } else {
        echo "Cost Center Insertion Error: Required fields cannot be empty.";
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