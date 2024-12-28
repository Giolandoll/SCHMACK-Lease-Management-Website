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
    $Lease_Start_Date = isset($_POST['lease_start_date']) ? $_POST['lease_start_date'] : null;
    $Lease_Termination_Date = isset($_POST['lease_termination_date']) ? $_POST['lease_termination_date'] : null;
    $Yearly_Cost = isset($_POST['yearly_cost']) ? $_POST['yearly_cost'] : null;
    $Monthly_Cost = isset($_POST['monthly_cost']) ? $_POST['monthly_cost'] : null;
    $Terminated_Lease = isset($_POST['terminated_lease']) ? 1 : 0;  // Checkbox for terminated lease
    $CostCenter_ID = isset($_POST['costcenter_id']) ? $_POST['costcenter_id'] : null;
    $Subsidiary_ID = isset($_POST['subsidiary_id']) ? $_POST['subsidiary_id'] : null;

    // Validate required fields
    if (!empty($Lease_Start_Date) && !empty($Yearly_Cost) && !empty($Monthly_Cost) && !empty($CostCenter_ID) && !empty($Subsidiary_ID)) {
        // Prepare the SQL statement to insert data into the Lease table
        $query = "INSERT INTO Leases (Lease_Start_Date, Lease_Termination_Date, Yearly_Cost, Monthly_Cost, Terminated_Lease, CostCenter_ID, Subsidiary_ID) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters: note that Terminated_Lease is an integer
        $stmt->bind_param("ssddiii", $Lease_Start_Date, $Lease_Termination_Date, $Yearly_Cost, $Monthly_Cost, $Terminated_Lease, $CostCenter_ID, $Subsidiary_ID);

        // Execute the statement
        if ($stmt->execute()) {
            // Success message
            echo "Lease created successfully!";
        } else {
            // Error message
            echo "Error inserting lease: " . $stmt->error;
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
