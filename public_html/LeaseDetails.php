<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database configuration file
require 'db_config.php'; // Make sure this file is in the same directory

// Create a new MySQLi connection using constants from db_config.php
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the Lease_ID from the URL
$leaseID = $_GET['id'];

// Prepare the SQL statement to fetch lease details
$stmt = $mysqli->prepare("
    SELECT l.Lease_ID, l.Lease_start_date, l.Lease_termination_date, 
           l.Monthly_Cost, l.Yearly_Cost, cc.CostCenter_Name
    FROM Leases l
    INNER JOIN CostCenter cc ON l.CostCenter_ID = cc.CostCenter_ID
    WHERE l.Lease_ID = ?
");
$stmt->bind_param("i", $leaseID);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch the details
$lease = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease Details</title>
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
            <h2>Details for Lease ID: <?php echo $lease['Lease_ID']; ?></h2>
            <p><strong>Cost Center Name:</strong> <?php echo $lease['CostCenter_Name']; ?></p>
            <p><strong>Start Date:</strong> <?php echo $lease['Lease_start_date']; ?></p>
            <p><strong>Termination Date:</strong> <?php echo $lease['Lease_termination_date']; ?></p>
            <p><strong>Monthly Cost:</strong> <?php echo $lease['Monthly_Cost']; ?></p>
            <p><strong>Yearly Cost:</strong> <?php echo $lease['Yearly_Cost']; ?></p>
        </div>
    </section>

    <?php
    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
    ?>
</body>
</html>
