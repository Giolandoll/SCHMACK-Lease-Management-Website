<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Search Results</title>
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
        <h2>Vehicle Search Results</h2>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Include the db_config.php file for connection details
        require 'db_config.php'; // Ensure the file is correctly located

        // Create a new MySQLi connection using the constants from db_config.php
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the input from the form
        $subsidiaryName = $_POST['Subsidiary_Name'];
        $leaseStatus = $_POST['Lease_Status']; // Assuming lease status is derived from Terminated_Lease

        // Prepare and bind the SQL statement
        $terminatedCondition = ($leaseStatus === 'Active') ? 0 : 1;

        $stmt = $conn->prepare("
            SELECT 
                V.Vehicle_ID, 
                S.Subsidiary_Name, 
                V.Vehicle_model, 
                L.Terminated_Lease
            FROM 
                Vehicle V
            JOIN 
                Leases L ON V.Lease_ID = L.Lease_ID
            JOIN 
                Subsidiaries S ON L.Subsidiary_ID = S.Subsidiary_ID
            WHERE 
                S.Subsidiary_Name LIKE ? 
                AND L.Terminated_Lease = ?
        ");

        $likeName = "%" . $subsidiaryName . "%";
        $stmt->bind_param("si", $likeName, $terminatedCondition);

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results were returned
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Vehicle ID</th><th>Subsidiary Name</th><th>Vehicle Model</th><th>Lease Status</th><th>Details</th></tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $leaseStatusOutput = $row['Terminated_Lease'] ? 'Terminated' : 'Active';
                echo "<tr>
                        <td>" . $row['Vehicle_ID'] . "</td>
                        <td>" . $row['Subsidiary_Name'] . "</td>
                        <td>" . $row['Vehicle_model'] . "</td>
                        <td>" . $leaseStatusOutput . "</td>
                        <td><a href='vehicledetails.php?id=" . $row['Vehicle_ID'] . "'>View Details</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for Subsidiary Name: $subsidiaryName and Lease Status: $leaseStatus</p>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </section>
</body>
</html>
