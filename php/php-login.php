<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'user-connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/Applications/XAMPP/xamppfiles/htdocs/interface/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $checkadmin = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    $checkuser = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");

    date_default_timezone_set('Asia/Manila');

    if ($row = mysqli_fetch_assoc($checkadmin)) {
        $hashedPassword = $row['password'];
        if (password_verify($pass, $hashedPassword)) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['token'] = $row['department_id'];

            // Send an email on successful login using PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'elocker70@gmail.com';
                $mail->Password   = "keaa rrvb svmg zmdn";
                $mail->SMTPSecure = "tls";
                $mail->Port       = 587;

                $mail->setFrom('locker70@gmail.com', 'Elocker');
                $mail->addAddress($email, ' ');

                $mail->isHTML(true);
                $mail->Subject = 'Login Successful';
                $mail->Body    = 'Hello ' . $row['fname'] . ",<br><br>You have successfully logged in to the admin dashboard on " . date('Y-m-d H:i:s') . '.';
                
                $mail->send();
                
            } catch (Exception $e) {
                echo "Mailer Error: {$mail->ErrorInfo}";
            }

            header('Location: admin/admin-dashboard.php');
            exit();
        } else {
            $error = "Incorrect password";
        }
    } elseif ($row = mysqli_fetch_assoc($checkuser)) {
        $hashedPassword = $row['password'];
        if (password_verify($pass, $hashedPassword)) {
            session_start();
            $_SESSION['email'] = $email;

            // Send an email on successful login using PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'elocker70@gmail.com';
                $mail->Password   = "keaa rrvb svmg zmdn";
                $mail->SMTPSecure = "tls";
                $mail->Port       = 587;

                $mail->setFrom('locker70@gmail.com', 'Elocker');
                $mail->addAddress($email, ' ');

                $mail->isHTML(true);
                $mail->Subject = 'Login Successful';
                $mail->Body    = 'Hello ' . $row['fname'] . ",<br><br>You have successfully logged in to the user dashboard on " . date('Y-m-d H:i:s') . '.';
                
                $mail->send();
                
            } catch (Exception $e) {
                echo "Mailer Error: {$mail->ErrorInfo}";
            }

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
