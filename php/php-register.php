<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../user-connection.php');

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
    $result1 = mysqli_query($conn, "SELECT email FROM user_data WHERE email = '$email' || idno= $idno ");
    $result2 = mysqli_query($conn, "SELECT email FROM admin WHERE email = '$email'");

   

    if ($result) {
        if (mysqli_num_rows($result) > 0 ) {
            echo "Email already on the list!";

         } elseif(mysqli_num_rows($result1) > 0){
            echo "An account is already created using this email or ID number!";

            

        } elseif(mysqli_num_rows($result2) > 0){
            echo "An account is already created using this email!";

        } else {

            $insertQuery = mysqli_query($conn, 
            "INSERT INTO requestlist (email,idno, fname, mi, lname, sex, course_id, department_id, yrsec) 
                            VALUES ('$email','$idno','$fname','$mi','$lname','$sex',$course_id,$department_id,'$yrsec')");

            if ($insertQuery) {
                echo "success";

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
