<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require("../user-connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$email = $_SESSION['email'];

$sql = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
if ($sql) {
    if ($row = mysqli_fetch_assoc($sql)) {
        $profile = $row['profile'];
        $id = $row['id'];
        $email = $row['email'];
        $fname = $row['fname'];
        $mi = $row['mi'];
        $lname = $row['lname'];
        $sex = $row['sex'];
        $pos = $row['position']; 
        $department_id = $row['department_id'];  
 

        } else {
        echo '<script>alert("User not found.")</script>';
        header('Location: ../landing-page.php');
        exit;

    }
} else {
    echo '<script>alert("Error in SQL query: ' . mysqli_error($conn) . '")</script>';
}
$sql->close();
?>