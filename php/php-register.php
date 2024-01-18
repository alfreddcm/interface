<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../user-connection.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/Applications/XAMPP/xamppfiles/htdocs/integ/vendor/autoload.php';


$otp_str = str_shuffle("0123456789");
$otp = substr($otp_str, 0, 5);

$act_str = rand(100000, 10000000);
$activation_code = str_shuffle("abcdefghijklmno".$act_str);

date_default_timezone_set('Asia/Manila');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $idno = $_POST['idno'];
    $fname = $_POST['fname'];
    $mi = $_POST['mi'];
    $lname = $_POST['lname'];
    $sex = $_POST['sex'];
    $course_id = $_POST['course'];
    $department_id = $_POST['dep'];
    $yrsec = $_POST['ysec'];

    $result = mysqli_query($conn, "SELECT email FROM requestlist WHERE email = '$email'");
    $result4 = mysqli_query($conn, "SELECT email FROM requestlist WHERE email = '$email' && otp is not null");

    $result1 = mysqli_query($conn, "SELECT email FROM user_data WHERE email = '$email' || idno= $idno ");
    $result2 = mysqli_query($conn, "SELECT email FROM admin WHERE email = '$email'");

   

    if ($result) {
        if (mysqli_num_rows($result4) > 0 ) {
            echo "Email on the list but need verification!"; 


         } elseif(mysqli_num_rows($result1) > 0){
            echo "An account is already created using this email or ID number!";

    
        } elseif(mysqli_num_rows($result2) > 0){
            echo "An account is already created using this email!";

        }elseif(mysqli_num_rows($result) > 0){
            echo "Email already on the list!";

        }else {

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
                $mail->Subject = 'Email Verification';
                $mail->Body = 'Hello ' . $fname . ' ' . $mi . '. ' . $lname . ',<br><br>' .
                'This is your One Time Pin (OTP): ' . $otp . '<br>' .
                'Date: ' . date('F j, Y') . '<br>' .
                'Time: ' . date('g:i a');
            
            $mail->IsHTML(true);                 
                $mail->send();
                
            } catch (Exception $e) {
                $response['error'] = "Mailer Error: {$mail->ErrorInfo}";
            }

            $insertQuery = mysqli_query($conn, 
            "INSERT INTO requestlist (email,idno, fname, mi, lname, sex, course_id, department_id, yrsec, otp) 
                            VALUES ('$email','$idno','$fname','$mi','$lname','$sex',$course_id,$department_id,'$yrsec', '$otp' )");

            if ($insertQuery) {
                echo "success".$email ;

            } else {
                echo "<script>
                        alert('Error inserting email: " . mysqli_error($conn) . "');
                        window.location.href='../index.php';

                        </script>";
            }
        }
    } else {
        echo "<script>
                alert('Error executing the query: " . mysqli_error($conn) . "');
                window.location.href='../index.php';

             </script>";
    }
}
?>
