<?php
session_start();

$response = ["success" => false, "message" => ""];

try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $response["message"] = "Both fields are required.";
            echo json_encode($response);
            exit;
        }

        // Log incoming data
        error_log("Username: " . $username);
        error_log("Password: " . $password);

        // Connect to the database
        // Replace placeholders with actual database credentials
        $mysqli = new mysqli("localhost", "", "", "purepet");

        // Check for connection errors
        if ($mysqli->connect_error) {
            throw new Exception("Connection failed: " . $mysqli->connect_error);
        }

        // Prepare and bind the SQL statement
        $stmt = $mysqli->prepare("SELECT username, password_hash, user_type FROM users WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $mysqli->error);
        }
        
        $stmt->bind_param("s", $username);

        // Execute the SQL statement
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($id, $hashed_password, $accountType);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set the session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $accountType; // Add user type to session

                $response["success"] = true;
                $response["user_type"] = $accountType; // Add user type to response
            } else {
                $response["message"] = "Incorrect password!";
            }
        } else {
            $response["message"] = "User not found!";
        }

        // Close the connection
        $stmt->close();
        $mysqli->close();
    } else {
        $response["message"] = "Both fields are required.";
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>
