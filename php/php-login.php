<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'user-connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/Applications/XAMPP/xamppfiles/htdocs/interface/vendor/autoload.php';

$response = array(); // Initialize an array to store the response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start(); // Start or resume a session

    $email = $_POST['email'];
    $pass = $_POST['password'];

    $checkadmin = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    $checkuser = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");

    date_default_timezone_set('Asia/Manila');

    if ($row = mysqli_fetch_assoc($checkadmin)) {
        $hashedPassword = $row['password'];
        if (password_verify($pass, $hashedPassword)) {
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
                $response['error'] = "Mailer Error: {$mail->ErrorInfo}";
            }

            $response['redirect'] = 'admin/admin-dashboard.php';
        } else {
            $response['error'] = "Incorrect password";
        }
    } elseif ($row = mysqli_fetch_assoc($checkuser)) {
        if($row['locker_id']==null){
            $response['error'] = "Sorry, you don't have a locker yet. Please wait for preparations.";

        }else{

        $hashedPassword = $row['password'];
        if (password_verify($pass, $hashedPassword)) {
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
                $response['error'] = "Mailer Error: {$mail->ErrorInfo}";
            }

            $response['redirect'] = 'user-dashboard.php';
        } else {
            $response['error'] = "Incorrect password";
        }
    }
    }
    elseif(mysqli_num_rows($checkuser) > 0){
        $response['error'] = "Sorry, you don't have a locker yet. Please wait for preparations.";

    }
     else {
        $response['error'] = "Invalid email: $email! Please click request access for access.";
    }

    echo json_encode($response); // Return the JSON response
    exit;
}
?>
