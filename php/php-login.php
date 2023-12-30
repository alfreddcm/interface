<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('user-connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $checkadmin = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    $checkuser = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");

    
    if ($row = mysqli_fetch_assoc($checkadmin)) {
        $hashedPassword = $row['password'];
        if (password_verify($pass, $hashedPassword)) {
            session_start();
            $_SESSION['email'] =$email;
            $_SESSION['token']=$row['department_id'];
            header('Location: admin/admin-dashboard.php');
            exit();
        } else {
            $error = "Incorrect password";
        }
    } elseif ($row = mysqli_fetch_assoc($checkuser)) {
        $hashedPassword = $row['password'];
        if (password_verify($pass, $hashedPassword)) {
            session_start();
            $_SESSION['email'] =$email;
            header('Location: user-dashboard.php');
            exit();
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Invalid email: $email! Please click request access for access.";
    }
}

// Output the error directly on the page
if (isset($error)) {
    echo "<script>alert('$error')</script>";
}
?>
