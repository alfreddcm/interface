<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../user-connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $newPassword = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
    
    if ($row = mysqli_fetch_assoc($sql)) {
        $id = $row['id'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE user_data SET password = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $id);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating password: ' . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update query preparation failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error retrieving user data.']);
    }
}
?>
