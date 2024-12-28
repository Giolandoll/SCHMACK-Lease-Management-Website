<?php
// Database connection parameters
$host = '5.75.182.107'; // e.g., 'localhost'
$dbname = 'wbilal_db'; // Your database name
$username = 'wbilal'; // Your database username
$password = 'hUoRPe'; // Your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the database successfully.<br>";

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("SELECT Lease_ID FROM Leases");
    $stmt->execute();

    // Fetch all lease data
    $leases = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($leases) {
        echo "<h2>Lease Data:</h2>";
        foreach ($leases as $lease) {
            echo "Lease ID: " . htmlspecialchars($lease['Lease_ID']) . "<br>";
        }
    } else {
        echo "No lease data found.";
    }

    // Close the database connection
    $pdo = null;

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
