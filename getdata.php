<?php
require('../user-connection.php');

date_default_timezone_set('Asia/Manila');
$d = date("Y-m-d");
$t = date("H:i:sa");

if (isset($_GET['card_uid']) && isset($_GET['device_token'])) {

    $card_uid = $_GET['card_uid'];
    $token = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE token=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    } else {

        mysqli_stmt_bind_param($result, "s", $token);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {
            $device_mode = $row['device_mode'];
            if ($device_mode == 1) {
                // logging
                $sql = "SELECT * FROM locker_data WHERE uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_card";
                    exit();
                } else {

                    mysqli_stmt_bind_param($result, "s", $card_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);

                    if ($row = mysqli_fetch_assoc($resultl)) {
                        $lockerid = $row['id'];

                        $checkLockerQuery = "SELECT * FROM user_data WHERE locker_id = ?";
                        $checkLockerStmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($checkLockerStmt, $checkLockerQuery)) {
                            echo "SQL_Error_Check_Locker";
                            exit();
                        }

                        mysqli_stmt_bind_param($checkLockerStmt, "s", $lockerid);
                        mysqli_stmt_execute($checkLockerStmt);
                        $checkResult = mysqli_stmt_get_result($checkLockerStmt);

                        if ($checkRow = mysqli_fetch_assoc($checkResult)) {
                            $insertLogQuery = "INSERT INTO Log_history (locker_id, date_time, access) VALUES (?, NOW(), 'RFID')";
                            $insertLogStmt = mysqli_stmt_init($conn);

                            if (!mysqli_stmt_prepare($insertLogStmt, $insertLogQuery)) {
                                echo "SQL_Error_Insert_Log";
                                exit();
                            }

                            mysqli_stmt_bind_param($insertLogStmt, "s", $lockerid);
                            mysqli_stmt_execute($insertLogStmt);

                            echo "logged" . $lockerid;
                        } else {
                            echo "available";  
                        }
                    } else {
                        echo "Not Registered";
                        exit();
                    }
                }
            } else if ($device_mode == 0) {

                session_start();

                $sql = "SELECT * FROM locker_data WHERE uid = ?";
                $stmt_locker = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt_locker, $sql)) {
                    mysqli_stmt_bind_param($stmt_locker, "i", $card_uid);
                    mysqli_stmt_execute($stmt_locker);
                    $result_locker = mysqli_stmt_get_result($stmt_locker);

                    if (mysqli_num_rows($result_locker) > 0) {
                        $_SESSION['Error'] = "UID is already on the locker_data"; // or "error", "info", etc.

                        echo "UID is already on the locker_data";
                    } else {
                        // Check if UID is in newcard
                        $sql_check_newcard = "SELECT * FROM newcard WHERE uid = ?";
                        $stmt_check_newcard = mysqli_stmt_init($conn);

                        if (mysqli_stmt_prepare($stmt_check_newcard, $sql_check_newcard)) {
                            mysqli_stmt_bind_param($stmt_check_newcard, "i", $card_uid);
                            mysqli_stmt_execute($stmt_check_newcard);
                            $result_check_newcard = mysqli_stmt_get_result($stmt_check_newcard);

                            if (mysqli_num_rows($result_check_newcard) > 0) {
                                $_SESSION['Error'] = "UID is already on the list, not registered"; // or "error", "info", etc.

                                echo "UID is already on the list, not registered";
                            } else {
                                // Insert into newcard if UID is new
                                $insert_newcard = "INSERT INTO newcard (uid) VALUES (?)";
                                $stmt_insert_newcard = mysqli_stmt_init($conn);

                                if (mysqli_stmt_prepare($stmt_insert_newcard, $insert_newcard)) {
                                    mysqli_stmt_bind_param($stmt_insert_newcard, "i", $card_uid);

                                    if (mysqli_stmt_execute($stmt_insert_newcard)) {
                                        $_SESSION['success'] = "Card added to newcard!"; // or "error", "info", etc.

                                        echo "succesful";
                                    } else {
                                        echo "Error inserting into newcard: " . mysqli_error($conn);
                                    }

                                    mysqli_stmt_close($stmt_insert_newcard);
                                } else {
                                    echo "Statement preparation failed for newcard insertion.";
                                }
                            }

                            mysqli_stmt_close($stmt_check_newcard);
                        } else {
                            echo "Statement preparation failed for checking newcard.";
                        }
                    }

                    mysqli_stmt_close($stmt_locker);
                } else {
                    echo "Statement preparation failed for locker_data.";
                }
                header("Location: ../php/add-locker.php");
                exit();
            }
        }
    }
} else {
    // get device status
}

mysqli_close($conn);
