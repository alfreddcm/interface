<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("../user-connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize email
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';

    if (!empty($email)) {
        try {
            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM user_data WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userId = $row['id'];


                // Delete the row with the email
                $deleteStmt = $conn->prepare("DELETE FROM user_data WHERE email = ?");
                $deleteStmt->bind_param("s", $email);
                $deleteStmt->execute();
                $resetAutoIncrement = "ALTER TABLE user_data AUTO_INCREMENT = 1";
                $conn->query($resetAutoIncrement);

                // Send response to AJAX
                echo "User with email $email has been deleted and locker_data updated.";
            } else {
                echo "User with email $email not found.";
            }

            $stmt->close();
            $deleteStmt->close();
            $conn->close();

        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage(), 0);
            echo "An error occurred while processing the request. Please check the logs for more details.";
        }
    } else {
        echo "Invalid email address.";
    }
}
?>
