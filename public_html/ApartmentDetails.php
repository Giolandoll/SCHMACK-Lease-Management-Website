<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database configuration file
require 'db_config.php';

// Create a new MySQLi connection using constants from db_config.php
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the Apartment ID from the URL
$apartmentID = $_GET['id'];

// Prepare the SQL statement to fetch apartment details
$stmt = $mysqli->prepare("
    SELECT a.Apartment_name, a.Apartment_location, 
           l.Lease_ID, l.Lease_start_date, l.Lease_termination_date, l.Monthly_Cost, l.Yearly_Cost
    FROM Apartment a
    LEFT JOIN Leases l ON a.Lease_ID = l.Lease_ID
    WHERE a.Apartment_ID = ?
");
$stmt->bind_param("i", $apartmentID);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch the details
$apartment = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Details</title>
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
            <h2>Details for Apartment: <?php echo htmlspecialchars($apartment['Apartment_name']); ?></h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($apartment['Apartment_location']); ?></p>
            <h3>Lease Details:</h3>
            <p><strong>Lease ID:</strong> <?php echo htmlspecialchars($apartment['Lease_ID']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($apartment['Lease_start_date']); ?></p>
            <p><strong>Termination Date:</strong> <?php echo htmlspecialchars($apartment['Lease_termination_date']); ?></p>
            <p><strong>Monthly Cost:</strong> <?php echo htmlspecialchars($apartment['Monthly_Cost']); ?> EUR</p>
            <p><strong>Yearly Cost:</strong> <?php echo htmlspecialchars($apartment['Yearly_Cost']); ?> EUR</p>
        </div>
    </section>

    <?php
    // Close the statement and connection
    $stmt->close();
    $mysqli->close();
    ?>
</body>
</html>
