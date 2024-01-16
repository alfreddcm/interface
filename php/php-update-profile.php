<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('user-connection.php');

$sql = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
if ($row = mysqli_fetch_assoc($sql)) {
    // Extract user data
    $id = $row['id'];
} else {
    echo "Error retrieving user data!";
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newemail =$_POST['email'];
    $newIdno = $_POST["idno"];
    $fname = $_POST["fname"];
    $mi = $_POST["mi"];
    $lname = $_POST["lname"];
    $sex = $_POST["sex"];
    $dep_id = $_POST["depid"];
    $course_id = $_POST["course"];
    $ysec = $_POST["ysec"];

    // Check if the new email is in use
    $checkemailQuery = "SELECT id FROM user_data WHERE email = ? AND id <> ?";
    $stmt = mysqli_prepare($conn, $checkemailQuery);
        if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $newemail, $id);
        mysqli_stmt_execute($stmt);
        $resultemail = mysqli_stmt_get_result($stmt);

        // Check if there are rows in the result
        if (mysqli_num_rows($resultemail) > 0) {
        echo "The email is already in use. ";
        exit; 
        }
    }
    // Check if the new idno is in use
    $checkIdnoQuery = "SELECT id FROM user_data WHERE idno = ? AND id <> ?";
    $stmt2 = mysqli_prepare($conn, $checkIdnoQuery);
    
    // Check if the prepare statement was successful
    if ($stmt2) {
        mysqli_stmt_bind_param($stmt2, "ss", $newIdno, $id);
            mysqli_stmt_execute($stmt2);
            $resultIdno = mysqli_stmt_get_result($stmt2);
        if (mysqli_num_rows($resultIdno) > 0) {
        echo "Error: Id no is already in use.";
        exit; 
    }

    $updateQuery = "UPDATE user_data SET 
        email = '$newemail',
        idno = '$newIdno',
        fname = '$fname',
        mi = '$mi',
        lname = '$lname',
        sex = '$sex',
        Department_id='$dep_id',
        yrsec='$ysec',
        course_id='$course_id'
        WHERE id = $id";

    if (mysqli_query($conn, $updateQuery)) {
        
        $_SESSION['email'] = $newemail;
        echo "success";

        exit; 
    } else {
        echo "<script>alert('Error: Updating profile.');
        window.location = 'user-profile.php';        
                </script> ";
        exit; 
    }
}
exit;
}
?>
