<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include ("../user-connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $emailToRemove = $_POST['email'];
        $emailToRemove = $conn->real_escape_string($emailToRemove);

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
            $mail->addAddress($emailToRemove, ' ');
    
            $mail->isHTML(true);
            $mail->Subject = 'Request Rejected';
            $mail->Body    = 'Sorry' . $email . ', we sadly inform your that request has been rejected due to unreasonable reason. Thank you! ';
    
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
    
                $sql = "DELETE FROM requestlist WHERE email = '$emailToRemove'";
                $result = $conn->query($sql);
        
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to remove the email. ' . $conn->error]);
                }
                $conn->close();
            } else {
                echo json_encode(['success' => false, 'error' => 'Email parameter not set']);
            }
    
            $stmt->close();
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}", 0);
            echo "An error occurred while sending the email. Please check the logs for more details.";
        }

            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            }
}
?>
