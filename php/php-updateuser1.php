<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../user-connection.php';

function sendErrorResponse($message) {
    $response = array(
        'status' => 'error',
        'message' => $message,
    );
    echo json_encode($response);
    exit;
}

function checkExistingEmail($conn, $newemail, $id) {
    $checkEmailQuery = "SELECT email FROM user_data WHERE email = ? AND id <> ?";
    $stmt = mysqli_prepare($conn, $checkEmailQuery);

    if (!$stmt) {
        sendErrorResponse('Email check preparation failed.');
    }

    mysqli_stmt_bind_param($stmt, "ss", $newemail, $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_num_rows($result) > 0;
}

function checkExistingIdNumber($conn, $newIdno, $id) {
    $checkIdnoQuery = "SELECT idno FROM user_data WHERE idno = ? AND id <> ?";
    $stmt = mysqli_prepare($conn, $checkIdnoQuery);

    if (!$stmt) {
        sendErrorResponse('ID number check preparation failed.');
    }

    mysqli_stmt_bind_param($stmt, "ss", $newIdno, $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_num_rows($result) > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $newemail = $_POST['email'];
    $newIdno = $_POST["idno"];
    $fname = $_POST["fname"];
    $mi = $_POST["mi"];
    $lname = $_POST["lname"];
    $sex = $_POST["sex"];
    $dep_id = $_POST["depid"];
    $course_id = $_POST["course"];
    $yrsec = $_POST["yrsec"];

    // Check if email is already in use
    if (checkExistingEmail($conn, $newemail, $id)) {
        sendErrorResponse('The email is already in use.');
    }

    // Check if ID number is already in use
    if (checkExistingIdNumber($conn, $newIdno, $id)) {
        sendErrorResponse('ID number is already in use.');
    }

    // Start database transaction
    mysqli_begin_transaction($conn);

    try {
        $updateQuery = "UPDATE user_data SET 
            email = ?,
            idno = ?,
            fname = ?,
            mi = ?,
            lname = ?,
            sex = ?,
            Department_id = ?,
            yrsec = ?,
            course_id = ?
            WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);

        if (!$stmt) {
            throw new Exception("Update query preparation failed");
        }

        mysqli_stmt_bind_param($stmt, "ssssssssss", $newemail, $newIdno, $fname, $mi, $lname, $sex, $dep_id, $yrsec, $course_id, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Commit the transaction
        if (mysqli_commit($conn)) {
            mysqli_close($conn);
            $response = array(
                'status' => 'success',
                'message' => 'Updated!',
            );
            echo json_encode($response);
        } else {
            $error = mysqli_error($conn);
            throw new Exception("Transaction commit failed. Error: " . $error);
        }
    } catch (Exception $e) {
        // Rollback the transaction on exception
        mysqli_rollback($conn);
        mysqli_close($conn);
        $errorMessage = htmlspecialchars($e->getMessage());
        sendErrorResponse($errorMessage);
    }
} else {
    sendErrorResponse('Invalid request method.');
}
?>
