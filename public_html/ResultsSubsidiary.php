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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subsidiary Search Results</title>
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

    <section class="results">
        <div class="card">
            <h2>Subsidiary Search Results</h2>
            <?php
            // Get the input from the form
            $subsidiaryName = $_POST['Subsidiary_Name'];

            // Prepare and bind the SQL statement
            $stmt = $mysqli->prepare("SELECT Subsidiary_ID, Subsidiary_Name, Location FROM Subsidiaries WHERE Subsidiary_Name LIKE ?");
            $likeName = "%" . $subsidiaryName . "%"; // Using LIKE for partial matching
            $stmt->bind_param("s", $likeName);

            // Execute the statement
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any results were returned
            if ($result->num_rows > 0) {
                echo "<table><tr><th>Subsidiary Name</th><th>Location</th><th>Details</th></tr>";

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Display the results with a link to the details page
                    echo "<tr>";
                    echo "<td>" . $row['Subsidiary_Name'] . "</td>";
                    echo "<td>" . $row['Location'] . "</td>";
                    echo "<td><a href='subsidiaryDetails.php?id=" . $row['Subsidiary_ID'] . "'>View Details</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No results found for Subsidiary Name: $subsidiaryName</p>";
            }

            // Close the statement and connection
            $stmt->close();
            $mysqli->close();
            ?>
        </div>
    </section>
</body>
</html>
