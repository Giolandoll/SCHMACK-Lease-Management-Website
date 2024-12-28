<?php
include 'config.php'; // Database configuration
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (isset($_GET['term']) && isset($_GET['type'])) {
    $term = $_GET['term'] . '%';
    $type = $_GET['type'];
    $query = '';

    // Define query based on the input field type
    switch ($type) {
        case 'subsidiary':
            $query = "SELECT Subsidiary_Name FROM Subsidiaries WHERE Subsidiary_Name LIKE ?";
            break;
        case 'apartment':
            $query = "SELECT Apartment_Name FROM Apartment WHERE Apartment_Name LIKE ?";
            break;
        case 'costCenter':
            $query = "SELECT CostCenter_name FROM CostCenter WHERE CostCenter_name LIKE ?";
            break;
        default:
            echo json_encode([]);
            exit();
    }

    // Prepare and execute query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':term', $term, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return results as JSON
    echo json_encode($result);
}
?>
