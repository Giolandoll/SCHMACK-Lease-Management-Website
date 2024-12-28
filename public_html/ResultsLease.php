<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease Search Results</title>
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
        <h2>Lease Search Results</h2>
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

        $costCenterName = $_POST['CostCenter_Name'];
        $startDate = $_POST['Lease_start_date'];
        $endDate = $_POST['Lease_termination_date'];

        $sql = "SELECT Leases.Lease_ID, Leases.Lease_start_date, Leases.Lease_termination_date, CostCenter.CostCenter_Name 
                FROM Leases 
                INNER JOIN CostCenter ON Leases.CostCenter_ID = CostCenter.CostCenter_ID 
                WHERE CostCenter.CostCenter_Name LIKE ?";

        if (!empty($startDate) && !empty($endDate)) {
            $sql .= " AND Leases.Lease_start_date >= ? AND Leases.Lease_termination_date <= ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $costCenterName, $startDate, $endDate);
        } else {
            $stmt = $conn->prepare($sql);
            $likeName = "%" . $costCenterName . "%";
            $stmt->bind_param("s", $likeName);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Lease ID</th><th>Cost Center Name</th><th>Start Date</th><th>Termination Date</th><th>Details</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['Lease_ID'] . "</td>
                        <td>" . $row['CostCenter_Name'] . "</td>
                        <td>" . $row['Lease_start_date'] . "</td>
                        <td>" . $row['Lease_termination_date'] . "</td>
                        <td><a href='leasedetails.php?id=" . $row['Lease_ID'] . "'>View Details</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for Cost Center Name: $costCenterName</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </section>
</body>
</html>
