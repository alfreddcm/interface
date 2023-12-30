<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../user-connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Ensure that this PHP script is being accessed via a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
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
        $mail->Subject = 'Request confirmation';
        $mail->Body    = 'Your locker access has been accepted. You can now create an account using ' . $email . '. Thank you! ';

        $mail->send();
        //updata
        $password = "Password123";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO user_data (email, idno, fname, mi, lname, sex, course_id, department_id, yrsec, locker_id, user_profile, password)  
                                SELECT email, idno, fname, mi, lname, sex, course_id, department_id, yrsec, NULL, 'blank-profile.png', ?
                                FROM requestlist 
                                WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {

            $sql = "DELETE FROM requestlist WHERE email = '$email'";
            echo 'Email has been sent successfully.;';
        } else {
            echo 'Error updating record: ' . $stmt->error . ';';
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}", 0);
        echo "An error occurred while sending the email. Please check the logs for more details.";
    }
}
