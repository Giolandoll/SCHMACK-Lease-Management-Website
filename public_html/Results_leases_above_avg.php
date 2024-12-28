<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leases Above Average Monthly Cost</title>
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
        <h2>Leases Above Average Monthly Cost</h2>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Include the db_config.php file
        require 'db_config.php'; // Make sure the file is correctly located

        // Create a new MySQLi connection using the constants from db_config.php
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL Query to find leases above the average monthly cost
        $sql = "SELECT Lease_ID, Monthly_Cost 
                FROM Leases 
                WHERE Monthly_Cost > (SELECT AVG(Monthly_Cost) FROM Leases)";

        $result = $conn->query($sql);

        // Display results
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>Lease ID: " . htmlspecialchars($row["Lease_ID"]) . " - Monthly Cost: $" . htmlspecialchars($row["Monthly_Cost"]) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No leases found with a monthly cost higher than the average.</p>";
        }

        $conn->close();
        ?>
    </section>

    <footer>
        <p>&copy; 2024 SHMACK. All rights reserved.</p>
        <a href="imprint.html">Imprint</a>
    </footer>
</body>
</html>
