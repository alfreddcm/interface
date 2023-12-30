<?php
require('../user-connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $sql = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
    
    if ($row = mysqli_fetch_assoc($sql)) {
        $id = $row['id'];
        $currentPasswordFromDatabase = $row['password'];

        $currentPassword = mysqli_real_escape_string($conn, $_POST["currentPassword"]);
        $newPassword = mysqli_real_escape_string($conn, $_POST["newPassword"]);

        if (!password_verify($currentPassword, $currentPasswordFromDatabase)) {
            echo "Error: Current password is incorrect.";
            exit;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE user_data SET password = '$hashedPassword' WHERE id = $id";

        if (mysqli_query($conn, $updateQuery)) {
            echo 'Password updated successfully.")';
        } else {
            echo "Error updating password: ' . mysqli_error($conn) . '";
        }
    } else {
        echo "Error retrieving user data.";
    }
}
?>
