<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../user-connection.php');

session_start(); 

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$token = $_SESSION['token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['device_mode'])) {
        
        $deviceMode = htmlspecialchars($_POST['device_mode']);

        $sql = "UPDATE devices SET device_mode=? WHERE token=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo '<p class="alert alert-danger">SQL Error</p>';
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $deviceMode, $token);
            mysqli_stmt_execute($stmt);
            echo $deviceMode;
        }
    }
}
?>
