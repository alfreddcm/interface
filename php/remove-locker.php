<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("../user-connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
    
    if (!empty($uid)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM locker_data WHERE uid = ?");
            $stmt->bind_param("s", $uid);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lockerid = $row['id'];

                $updateStmt = $conn->prepare("UPDATE user_data SET locker_id = null WHERE locker_id = ?");
                $updateStmt->bind_param("i", $lockerid);
                $updateStmt->execute();

                $deleteStmt = $conn->prepare("DELETE FROM locker_data WHERE id = ?");
                $deleteStmt->bind_param("s", $lockerid);
                $deleteStmt->execute();

                $resetAutoIncrement = "ALTER TABLE locker_data AUTO_INCREMENT = 1";
                $conn->query($resetAutoIncrement);
                
                echo "User with uid $uid has been deleted and locker_data updated.";
            } else {
                echo "User with uid $uid not found.";
            }

            $stmt->close();
            $updateStmt->close();
            $deleteStmt->close();
            $conn->close();

        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage(), 0);
            echo "An error occurred while processing the request. Please check the logs for more details.";
        }
    } else {
        echo "Invalid uid.";
    }
}
?>
