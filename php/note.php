<?php
include '../user-connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $idno = $_POST['idno'];
    $text = $_POST['text'];

    // Check if data exists for the specified idno
    $checkQuery = "SELECT text FROM Note WHERE idno = '$idno'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Data exists, perform an UPDATE query
        $updateQuery = "UPDATE Note SET text = '$text' WHERE idno = '$idno'";
        
        if (mysqli_query($conn, $updateQuery)) {
            echo "Success";
        } else {
            echo "error";
            echo "Error updating note: " . mysqli_error($conn);
        }
    } else {
        // No data exists, perform an INSERT query
        $insertQuery = "INSERT INTO Note (idno, text) VALUES ('$idno', '$text')";
        
        if (mysqli_query($conn, $insertQuery)) {
            echo "Success";       
        } else {
            echo "Error inserting note: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
