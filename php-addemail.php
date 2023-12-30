<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("user-connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($email)) {
        echo "<script>
            alert('Email connot be empty!');
        </script>";
    } else {
       
        $checkuser = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
        $checkadmin = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
        $checkemail = mysqli_query($conn, "SELECT * FROM emails WHERE email = '$email' AND status = 'pending'");
        if (mysqli_num_rows($checkuser) > 0 || mysqli_num_rows($checkadmin) > 0 || mysqli_num_rows($checkemail) > 0) {
            echo "<script> alert('Email already in used!'); </script>";
        } else {
            $insertemail = mysqli_query($conn, "INSERT INTO emails (email, status) VALUES ('$email', 'pending')");
            if ($insertemail) {
            } else {
                echo "<script> alert('Error please check your email!');</script>";
            }
        }
        mysqli_close($conn);
    }
}
