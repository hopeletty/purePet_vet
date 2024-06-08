<?php
include 'db_connection.php';  // Ensure this file connects to your database

$response = ["success" => false];

try {
    $conn = openConnection();

    // Fetch hospitals
    $hospitalQuery = "SELECT hospital_id, name FROM Hospitals";
    $hospitalResult = $conn->query($hospitalQuery);
    $hospitals = $hospitalResult->fetchAll(PDO::FETCH_ASSOC);

    $response["hospitals"] = $hospitals;
    $response["success"] = true;
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>
