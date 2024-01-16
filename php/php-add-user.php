<?php
require '../user-connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST["lname"];
    $fname = $_POST["fname"];

    if (empty($fname) || empty($lname)) {
        echo "Please enter first and last name.'";

    } else {
            $email = $_POST["email"];
            $password = $_POST["psw"];
            $idno = $_POST["idno"];
            $mi = $_POST["mi"];
            $sex = $_POST["sex"];
            $dep_id = $_POST["dep"];
            $course_id = $_POST["course"];
            $ysec = $_POST["ysec"];
            $locker_id = $_POST["locker_id"];
            $profile = $_FILES['profile']['name'];
            $tmp_name = $_FILES['profile']['tmp_name'];

            $checkuser = mysqli_query($conn, "SELECT * FROM user_data WHERE idno = '$idno' OR email = '$email'");

            if (mysqli_num_rows($checkuser) > 0) {
                echo "User ID $idno and $email is already in use.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $targetDirectory = "../uploads/";

                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0755, true);
                }
                if (move_uploaded_file($tmp_name, $targetDirectory . $profile)) {
                    echo '<script>';
                    echo 'console.log("File uploaded successfully!");';
                    echo '</script>';
                    
                    $insertUserQuery = "INSERT INTO user_data (user_profile, idno, email, password, fname, mi, lname, sex, course_id, department_id, locker_id, yrsec)
                            VALUES ('$profile', '$idno', '$email', '$hashedPassword', '$fname', '$mi', '$lname', '$sex', '$course_id', '$dep_id', '$locker_id', '$ysec')";
                $sql=mysqli_query($conn, $insertUserQuery);

                echo "succes";

                } else {
                    echo "File upload failed!";
                }

                
            }
      
    }
    exit;
}
?>
