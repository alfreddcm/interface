<?php
require("user-connection.php");
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: landing-page.php');
    exit();
}

$email = $_SESSION['email'];
$sql = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
if ($row = mysqli_fetch_assoc($sql)) {

    $id = $row['id'];
    $email = $row['email'];
    $user_profile = $row['user_profile'];
    $idno = $row['idno'];
    $fname = $row['fname'];
    $mi = $row['mi'];
    $lname = $row['lname'];
    $sex = $row['sex'];
    $pass=$row['password'];
    $course_id = $row['course_id'];
    $department_id = $row['Department_id'];
    $locker_id = $row['locker_id'];
    $yrsec = $row['yrsec'];
    
} else {
    echo 'Error retrieving user data!';
}