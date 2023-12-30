<?php
require('../user-connection.php');

$sql = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
if ($row = mysqli_fetch_assoc($sql)) {
    // Extract user data
    $id = $row['id'];
} else {
    echo "<script>alert('Error retrieving user data!');
    window.location = 'admin-profile.php';        
    </script>
           ";
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newemail =$_POST['email'];
    $fname = $_POST["fname"];
    $mi = $_POST["mi"];
    $lname = $_POST["lname"];
    $sex = $_POST["sex"];
    $pos = $_POST["pos"];
    $dep_id = $_POST["depid"];


    // Check if the new email is in use
    $checkemailQuery = "SELECT id FROM admin WHERE email = ? AND id <> ?";
    $stmt = mysqli_prepare($conn, $checkemailQuery);
        if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $newemail, $id);
        mysqli_stmt_execute($stmt);
        $resultemail = mysqli_stmt_get_result($stmt);

        // Check if there are rows in the result
        if (mysqli_num_rows($resultemail) > 0) {
        echo "<script>alert('Error: The email is already in use.');
        window.location = 'admin-profile.php';        
                </script>
                ";
        exit; 
        }
    }

    $updateQuery = "UPDATE admin SET 
        email = '$newemail',
        fname = '$fname',
        mi = '$mi',
        lname = '$lname',
        sex = '$sex',
        Department_id='$dep_id',
        position='$pos'
        WHERE id = $id";

    if (mysqli_query($conn, $updateQuery)) {
        
        $_SESSION['email'] = $newemail;
        echo "<script>alert('Success');
        window.location = 'admin-profile.php';        
                </script>";

        exit; 
    } else {
        echo "<script>alert('Error: Updating profile.');
        window.location = 'admin-profile.php';        
                </script> ";
        exit; 
    }
}

?>
