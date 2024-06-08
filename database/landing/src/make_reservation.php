<?php
include 'db_connection.php';  // Ensure this file connects to your database

session_start();
$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session after login

$response = ["success" => false, "debug" => []];

try {
    $conn = openConnection();

    // Debugging: Check if user_id exists in session
    if (!isset($user_id)) {
        $response["message"] = "User not logged in.";
        echo json_encode($response);
        exit;
    }

    // Debugging: Check if user_id exists in the Users table
    $stmt = $conn->prepare("SELECT user_id FROM Users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $response["message"] = "User ID does not exist.";
        echo json_encode($response);
        exit;
    }

    $hospital_id = $_POST['hospital'];
    $diagnosis = $_POST['diagnosis'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];

    $stmt = $conn->prepare("INSERT INTO Reservations (pet_owner_id, hospital_id, diagnosis, reservation_date, reservation_time) VALUES (:pet_owner_id, :hospital_id, :diagnosis, :reservation_date, :reservation_time)");
    $stmt->bindParam(':pet_owner_id', $user_id);
    $stmt->bindParam(':hospital_id', $hospital_id);
    $stmt->bindParam(':diagnosis', $diagnosis);
    $stmt->bindParam(':reservation_date', $reservation_date);
    $stmt->bindParam(':reservation_time', $reservation_time);

    if ($stmt->execute()) {
        $response["success"] = true;
    } else {
        $response["message"] = "Error executing query.";
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
    $response["debug"][] = $e->getTraceAsString();  // Add debugging information
}

echo json_encode($response);
?>
