<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Search Results</title>
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
        <h2>Apartment Search Results</h2>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Include the db_config.php file
        require 'db_config.php'; // Ensure the file is correctly located

        // Create a new MySQLi connection using the constants from db_config.php
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the input from the form
        $city = $_POST['Apartment_location'];

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("SELECT * FROM Apartment WHERE Apartment_location LIKE ?");
        $likeCity = "%" . $city . "%"; // Using LIKE for partial matching
        $stmt->bind_param("s", $likeCity);

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results were returned
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>ID</th><th>Address</th><th>City</th><th>Details</th></tr>";

            // Output data of each row with clickable link to details
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['Apartment_ID'] . "</td><td>" . $row['Apartment_name'] . "</td><td>" . $row['Apartment_location'] . "</td>";
                echo "<td><a href='ApartmentDetails.php?id=" . $row['Apartment_ID'] . "'>View Details</a></td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for City: $city</p>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </section>
</body>
</html>
