<?php
// Include the database configuration file
require 'db_config.php'; // Make sure this file has the correct constants defined

try {
    // Create a new PDO instance using constants from db_config.php
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL query for subsidiaries
    $subsidiary_stmt = $pdo->prepare("SELECT Subsidiary_ID, Subsidiary_Name FROM Subsidiaries");
    $subsidiary_stmt->execute();
    $subsidiaries = $subsidiary_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate options for the subsidiary dropdown
    $subsidiary_options = '';
    foreach ($subsidiaries as $subsidiary) {
        $subsidiary_options .= '<option value="' . htmlspecialchars($subsidiary['Subsidiary_ID']) . '">' . htmlspecialchars($subsidiary['Subsidiary_Name']) . '</option>';
    }

    // Prepare and execute the SQL query for cost centers
    $costcenter_stmt = $pdo->prepare("SELECT CostCenter_ID, CostCenter_Name FROM CostCenter");
    $costcenter_stmt->execute();
    $costcenters = $costcenter_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate options for the cost center dropdown
    $costcenter_options = '';
    foreach ($costcenters as $costcenter) {
        $costcenter_options .= '<option value="' . htmlspecialchars($costcenter['CostCenter_ID']) . '">' . htmlspecialchars($costcenter['CostCenter_Name']) . '</option>';
    }

    // Close the database connection
    $pdo = null;

    // Output the dropdowns
    return [$subsidiary_options, $costcenter_options];

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>