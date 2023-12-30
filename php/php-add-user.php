<?php


require '../user-connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST["lname"];
    $fname = $_POST["fname"];

    if (empty($fname) || empty($lname)) {
        echo "<script>alert('Please enter first and last name.');
        </script>";

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
                echo "<script>alert('User ID $idno and $email is already in use.') </script>";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $targetDirectory = "../uploads/";
                move_uploaded_file($tmp_name, $targetDirectory . $profile);

                $insertUserQuery = "INSERT INTO user_data (user_profile, idno, email, password, fname, mi, lname, sex, course_id, department_id, locker_id, yrsec)
                            VALUES ('$profile', '$idno', '$email', '$hashedPassword', '$fname', '$mi', '$lname', '$sex', '$course_id', '$dep_id', '$locker_id', '$ysec')";

                if (mysqli_query($conn, $insertUserQuery)) {
                    $lastUserId = mysqli_insert_id($conn);
                    $updatelocker = mysqli_query($conn, "UPDATE locker_data SET user_id = $lastUserId WHERE id = $locker_id");

                    if ($updatelocker) {
                        echo "<script>alert('$email Account added! You can now log in.'); 
                        </script>";
                    } else {
                        echo "<script>alert('ID number is already in use!'); </script>";
                    }
                } else {
                    echo "<script>alert('Error executing the query: " . mysqli_error($conn) . "')</script>";
                }
            }
      
    }
}
?>
