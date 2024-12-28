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

// Collect the form data
$name = $mysqli->real_escape_string($_POST['Name']);
$email = $mysqli->real_escape_string($_POST['Email']);
$address = $mysqli->real_escape_string($_POST['Address']);
$role = $mysqli->real_escape_string($_POST['Role']);
$permissions_rights = $mysqli->real_escape_string($_POST['PermissionsRights']);
$subsidiary_id = $mysqli->real_escape_string($_POST['Subsidiary_ID']);

// Check if the cost center is relevant
if (isset($_POST['CostCenter_ID']) && !empty($_POST['CostCenter_ID'])) {
    $costcenter_id = $mysqli->real_escape_string($_POST['CostCenter_ID']);
} else {
    $costcenter_id = null; // Set to null if not provided
}

// Prepare and execute the insert query
$query = "INSERT INTO Users (Name, Email, Address, Role, Permissions_Rights, Subsidiary_ID, CostCenter_ID) VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

// Bind parameters
$stmt->bind_param("ssssssi", $name, $email, $address, $role, $permissions_rights, $subsidiary_id, $costcenter_id);

// Execute the statement
if ($stmt->execute()) {
    echo "New user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>
