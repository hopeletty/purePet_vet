<?php
include 'db_connection.php';  // Ensure this file connects to your database

session_start();
$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session after login

$response = ["success" => false];

try {
    $conn = openConnection();

    // Fetch hospital id for the logged-in user
    $stmt = $conn->prepare("SELECT hospital_id FROM Users WHERE user_id = :user_id AND user_type = 'hospital'");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $hospital_id = $user['hospital_id'];

    if ($hospital_id) {
        // Fetch reservations for the hospital
        $stmt = $conn->prepare("
            SELECT 
                U.username AS pet_owner, 
                R.diagnosis, 
                R.reservation_date, 
                R.reservation_time 
            FROM Reservations R
            JOIN Users U ON R.pet_owner_id = U.user_id
            WHERE R.hospital_id = :hospital_id
        ");
        $stmt->bindParam(':hospital_id', $hospital_id, PDO::PARAM_INT);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response["reservations"] = $reservations;
        $response["success"] = true;
    } else {
        $response["message"] = "No hospital associated with this user.";
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>
