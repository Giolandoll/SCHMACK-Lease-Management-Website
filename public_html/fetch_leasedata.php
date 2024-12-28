<?php
// Include the database configuration file
require 'db_config.php';  // Ensure this file contains constants for DB credentials

function getLeaseOptions() {
    // Use the constants from db_config.php
    try {
        // Create a new PDO instance using the constants defined in db_config.php
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query to fetch Lease IDs
        $stmt = $pdo->prepare("SELECT Lease_ID FROM Leases");
        $stmt->execute();

        // Fetch all lease data
        $leases = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate options for the dropdown
        $lease_options = '';
        foreach ($leases as $lease) {
            // Create an option with Lease_ID as value and display Lease_ID
            $lease_options .= '<option value="' . htmlspecialchars($lease['Lease_ID']) . '">' . htmlspecialchars($lease['Lease_ID']) . '</option>';
        }

        // Close the database connection
        $pdo = null;

        // Return the generated options
        return $lease_options;

    } catch (PDOException $e) {
        // Handle any PDO exceptions (connection or query issues)
        echo "Connection failed: " . $e->getMessage();
        return ''; // Return an empty string in case of error
    }
}

// Call the function and store the result in a variable
$lease_options = getLeaseOptions();
?>
