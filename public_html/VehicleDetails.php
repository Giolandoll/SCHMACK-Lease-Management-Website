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

// Get the Vehicle_ID from the URL
$vehicleID = $_GET['id'];

// Prepare the SQL statement to fetch vehicle details
$stmt = $mysqli->prepare("
    SELECT V.Vehicle_ID, V.Vehicle_model, S.Subsidiary_Name
    FROM Vehicle V
    INNER JOIN Leases L ON V.Lease_ID = L.Lease_ID
    INNER JOIN Subsidiaries S ON L.Subsidiary_ID = S.Subsidiary_ID
    WHERE V.Vehicle_ID = ?
");
$stmt->bind_param("i", $vehicleID);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch the details
$vehicle = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Details</title>
    <link rel="stylesheet" href="CSS/maintenance.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="logo.png" alt="SHMACK Logo" class="logo">
                <h1>SHMACK</h1>
            </div>
            <nav class="navbar">
                <ul class="navbar-list">
                    <li class="navbar-item"><a href="index.html" class="navbar-link">Home</a></li>
                    <li class="navbar-item"><a href="imprint.html" class="navbar-link">Imprint</a></li>
                    <li class="navbar-item"><a href="services.html" class="navbar-link">Services</a></li>
                    <li class="navbar-item"><a href="contact.html" class="navbar-link">Contact Us</a></li>
                    <li class="navbar-item"><a href="login.html" class="navbar-link">Maintenance</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="details">
        <div class="card">
            <h2>Details for Vehicle ID: <?php echo $vehicle['Vehicle_ID']; ?></h2>
            <p><strong>Vehicle Model:</strong> <?php echo $vehicle['Vehicle_model']; ?></p>
            <p><strong>Subsidiary Name:</strong> <?php echo $vehicle['Subsidiary_Name']; ?></p>
        </div>
    </section>

    <?php
    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
    ?>
</body>
</html>
