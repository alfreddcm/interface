<?php
include("php-userinfo.php");

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['psw'];
    $newPassword = $_POST['newpsw'];
    $confirmPassword = $_POST['confirmpassword'];

    $uppercase = preg_match('@[A-Z]@', $newPassword);
    $lowercase = preg_match('@[a-z]@', $newPassword);
    $number = preg_match('@[0-9]@', $newPassword);

    $email = mysqli_real_escape_string($conn, $_SESSION['email']);

    $slqf = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
    $sqldata = mysqli_fetch_assoc($slqf);

    if ($slqf) {
        $affectedRows = mysqli_affected_rows($conn);
        if ($affectedRows > 0) {
            $oldPassword = $sqldata['password'];
            if (!password_verify($password, $oldPassword)) {
                echo 'Current password doesn\'t match';
            } elseif (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
                echo 'Password should be at least 8 characters in length and include at least one uppercase letter, one lowercase letter, one number, and one special character.';
            } elseif ($newPassword != $confirmPassword) {
                echo 'Invalid confirm password';
            } else {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $userId = $sqldata['id'];
                $updateQuery = "UPDATE user_data SET password = '$hashedNewPassword' WHERE id = '$userId'";
                mysqli_query($conn, $updateQuery);

                echo 'success';

            }
        } else {
            echo "Update did not affect any rows.";
        }
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}
?>