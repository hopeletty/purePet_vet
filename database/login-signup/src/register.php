<?php
include 'db_connection.php';  // Ensure this file connects to your database

$response = ["success" => false];

try {
    $conn = openConnection();

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $accountType = $_POST['accountType'];

    if ($accountType === 'pet_owner') {
        $stmt = $conn->prepare("INSERT INTO Users (username, password_hash, email, user_type) VALUES (:username, :password_hash, :email, 'pet_owner')");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $passwordHash);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            $response["success"] = true;
        } else {
            $response["message"] = "Error executing query.";
        }
    } elseif ($accountType === 'hospital') {
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare("INSERT INTO Users (username, password_hash, email, user_type) VALUES (:username, :password_hash, :email, 'hospital')");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password_hash', $passwordHash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $userId = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO Hospitals (name, location) VALUES (:name, :location)");
            $stmt->bindParam(':name', $username);  // Assuming the hospital name is the username
            $stmt->bindParam(':location', $_POST['location']);  // Location should be added in the form
            $stmt->execute();

            $conn->commit();
            $response["success"] = true;
        } catch (Exception $e) {
            $conn->rollBack();
            $response["message"] = $e->getMessage();
        }
    } elseif ($accountType === 'hospital_employee') {
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare("INSERT INTO Users (username, password_hash, email, user_type) VALUES (:username, :password_hash, :email, 'hospital_employee')");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password_hash', $passwordHash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $userId = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO Hospital_Employees (hospital_id, employee_type, name, email, contact_number) VALUES (:hospital_id, :employee_type, :name, :email, :contact_number)");
            $stmt->bindParam(':hospital_id', $_POST['hospital_id']);  // Hospital ID should be added in the form
            $stmt->bindParam(':employee_type', $_POST['employee_type']);  // Employee type should be added in the form
            $stmt->bindParam(':name', $username);  // Assuming the employee name is the username
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact_number', $_POST['contact_number']);  // Contact number should be added in the form
            $stmt->execute();

            $conn->commit();
            $response["success"] = true;
        } catch (Exception $e) {
            $conn->rollBack();
            $response["message"] = $e->getMessage();
        }
    } else {
        $response["message"] = "Invalid account type.";
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>
