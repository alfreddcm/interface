<?php
require('../user-connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST["lname"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $password = $_POST["psw"];
    $mi = $_POST["mi"];
    $sex = $_POST["sex"];
    $pos = $_POST["position"];
    $dep_id = $_POST["dep"];
    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];


    if (empty($fname) || empty($lname)) {
        echo "<script>alert('Please confirm the password first!');
        window.location = '../admin/add-admin.php';
        </script>";
    } else {

        $checkuser = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");

        if (mysqli_num_rows($checkuser) > 0) {
            echo "<script>alert('$email is already in use.')</script>";
            exit;
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $targetDirectory = "../adminuploads/";
            move_uploaded_file($tmp_name, $targetDirectory . $profile);

            $insertUserQuery = "INSERT INTO admin (profile, email, password, fname, mi, lname, sex, position, department_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($insertUserQuery);
            $stmt->bind_param("ssssssiss", $profile, $email, $hashedPassword, $fname, $mi, $lname, $sex, $pos, $dep_id);

            if ($stmt->execute()) {
                echo "<script>alert('Account added! '); </script> ";
            } else {
                echo "<script>alert('Error adding account! '); </script>";
            }
        }
    }
}
