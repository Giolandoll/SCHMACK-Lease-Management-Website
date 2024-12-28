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

// Get the Subsidiary_ID from the URL
$subsidiaryID = $_GET['id'];

// Prepare the SQL statement to fetch subsidiary details
$stmt = $mysqli->prepare("
    SELECT s.Subsidiary_Name, s.Location, s.Workforce_Size, 
           l.Lease_ID, l.Lease_start_date, l.Lease_termination_date, l.Monthly_Cost, l.Yearly_Cost
    FROM Subsidiaries s
    LEFT JOIN Leases l ON s.Subsidiary_ID = l.Subsidiary_ID
    WHERE s.Subsidiary_ID = ?
");
$stmt->bind_param("i", $subsidiaryID);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch the details
$subsidiary = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subsidiary Details</title>
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
                    <li class="navbar-item"><a href="maintenance.html" class="navbar-link">Maintenance</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="details">
        <div class="card">
            <h2>Details for Subsidiary: <?php echo $subsidiary['Subsidiary_Name']; ?></h2>
            <p><strong>Location:</strong> <?php echo $subsidiary['Location']; ?></p>
            <p><strong>Workforce Size:</strong> <?php echo $subsidiary['Workforce_Size']; ?></p>
            <h3>Lease Details:</h3>
            <p><strong>Lease ID:</strong> <?php echo $subsidiary['Lease_ID']; ?></p>
            <p><strong>Start Date:</strong> <?php echo $subsidiary['Lease_start_date']; ?></p>
            <p><strong>Termination Date:</strong> <?php echo $subsidiary['Lease_termination_date']; ?></p>
            <p><strong>Monthly Cost:</strong> <?php echo $subsidiary['Monthly_Cost']; ?></p>
            <p><strong>Yearly Cost:</strong> <?php echo $subsidiary['Yearly_Cost']; ?></p>
        </div>
    </section>

    <?php
    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
    ?>
</body>
</html>
