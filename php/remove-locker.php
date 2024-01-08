<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include the user-connection.php file that presumably contains the database connection details
include("../user-connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the 'uid' parameter from the POST data or set it to null if not present
    $uid = isset($_POST['uid']) ? $_POST['uid'] : null;

    // Check if uid is not empty
    if (!empty($uid)) {
        try {
            // Select data from 'locker_data' table based on 'uid'
            $stmt = $conn->prepare("SELECT * FROM locker_data WHERE uid = ?");
            $stmt->bind_param("s", $uid);
            $stmt->execute();
            $result = $stmt->get_result();

            // Select data from 'newcard' table based on 'uid'
            $stmt2 = $conn->prepare("SELECT * FROM newcard WHERE uid = ?");
            $stmt2->bind_param("s", $uid);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $carduid = $row2['uid'];

            // If records found in 'locker_data' table
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lockerid = $row['id'];

                // Update 'user_data' to set 'locker_id' to null for the matching 'locker_id'
                $updateStmt = $conn->prepare("UPDATE user_data SET locker_id = null WHERE locker_id = ?");
                $updateStmt->bind_param("i", $lockerid);
                
                // If update is successful, proceed with deletion
                if ($updateStmt->execute()) {
                    // Delete the record from 'locker_data' table
                    $deleteStmt = $conn->prepare("DELETE FROM locker_data WHERE id = ?");
                    $deleteStmt->bind_param("i", $lockerid);
                    $deleteStmt->execute();

                    // Reset the auto-increment value for 'locker_data' table
                    $resetAutoIncrement = "ALTER TABLE locker_data AUTO_INCREMENT = 1";
                    $conn->query($resetAutoIncrement);
                }

                echo "User with uid $uid has been deleted, and locker_data updated.";
            } elseif ($carduid === $uid) {
                // If 'uid' matches a record in 'newcard' table, delete the record
                $deleteStmt = $conn->prepare("DELETE FROM newcard WHERE uid = ?");
                $deleteStmt->bind_param("s", $uid);
                $deleteStmt->execute();

                // Reset the auto-increment value for 'newcard' table
                $resetAutoIncrement = "ALTER TABLE newcard AUTO_INCREMENT = 1";
                $conn->query($resetAutoIncrement);

                echo "User with uid $uid has been deleted from newcard table.";
            } else {
                // If no records found for the given 'uid'
                echo "User with uid $uid not found.";
            }

            // Close prepared statements and the database connection
            $stmt->close();
            $updateStmt->close();
            $deleteStmt->close();
            $conn->close();

        } catch (Exception $e) {
            // Log any database errors
            error_log("Database Error: " . $e->getMessage(), 0);
            echo "An error occurred while processing the request. Please check the logs for more details.";
        }
    } else {
        // If 'uid' is empty
        echo "Invalid uid.";
    }
}
?>
