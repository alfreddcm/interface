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
                // Logging
                $sql = "SELECT * FROM locker_data WHERE uid='$card_uid'";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    echo "SQL_Error_Select_card: " . mysqli_error($conn);
                    exit();
                }

                if ($row = mysqli_fetch_assoc($result)) {
                    $lockerid = $row['id'];
                    $checkLockerQuery = "SELECT * FROM locker_data WHERE id = '$lockerid'";
                    $checkResult = mysqli_query($conn, $checkLockerQuery);
                    
                    if (!$checkResult) {
                        echo "SQL_Error_Check_Locker: " . mysqli_error($conn);
                        exit();
                    }

                    if ($checkRow = mysqli_fetch_assoc($checkResult)) {
                        $lastActionQuery = mysqli_query($conn, "SELECT access FROM Log_history WHERE locker_id = '$lockerid' ORDER BY date_time DESC LIMIT 1");
                        $lastAction = mysqli_fetch_assoc($lastActionQuery);

                        if (!$lastActionQuery || $lastAction === null) {
                            // Insert a new record with 'open' action
                            $insertLogQuery = mysqli_query(
                                $conn,
                                "INSERT INTO Log_history (locker_id, user_idno, user, date_time, access) 
                                    VALUES (
                                        $lockerid,
                                        (SELECT idno FROM user_data WHERE locker_id = $lockerid),
                                        (SELECT CONCAT(fname, ' ', mi, '. ', lname) FROM user_data WHERE locker_id = $lockerid),
                                        NOW(),
                                        'open'
                                    );
                                "
                            );
                            echo "Log " . $lockerid . " Open";
                        } elseif ($lastAction['access'] == 'open') {
                            // Insert a new record with 'close' action
                            $insertLogQuery = mysqli_query(
                                $conn,
                                "INSERT INTO Log_history (locker_id, user_idno, user, date_time, access) 
                                VALUES (
                                    $lockerid,
                                    (SELECT idno FROM user_data WHERE locker_id = $lockerid),
                                    (SELECT CONCAT(fname, ' ', mi, '. ', lname) FROM user_data WHERE locker_id = $lockerid),
                                    NOW(),
                                    'close'
                                );
                            "
                            );
                            echo "Log " . $lockerid . " Close";
                        } elseif ($lastAction['access'] == 'close') {
                            // Insert a new record with 'open' action
                            $insertLogQuery = mysqli_query(
                                $conn,
                                "INSERT INTO Log_history (locker_id, user_idno, user, date_time, access) 
                    VALUES (
                        $lockerid,
                        (SELECT idno FROM user_data WHERE locker_id = $lockerid),
                        (SELECT CONCAT(fname, ' ', mi, '. ', lname) FROM user_data WHERE locker_id = $lockerid),
                        NOW(),
                        'open'
                    );
                "
                            );
                            echo "Log " . $lockerid . " Open";
                        }
                    } else {
                        echo "Not Assigned";
                    }
                } else {
                    echo "Not Registered";
                    exit();
                }
            } else if ($device_mode == 0) {

            header("Location: manage_user_up.php?uid=" . urlencode($err));

            $insert_newcard = "INSERT INTO newcard (uid) VALUES (?)";
                                $stmt_insert_newcard = mysqli_stmt_init($conn);
            
                                if (mysqli_stmt_prepare($stmt_insert_newcard, $insert_newcard)) {
                                    mysqli_stmt_bind_param($stmt_insert_newcard, "i", $card_uid);
            
                                    if (mysqli_stmt_execute($stmt_insert_newcard)) {
                                        $message = "Successful";
                                    } else {
                                        $message = "Error inserting into newcard: " . mysqli_error($conn);
                                    }
            
                                    mysqli_stmt_close($stmt_insert_newcard);
            
                // header("Location: ../php/add-locker.php?message=" . urlencode($err));
                echo $message;
                exit();
                                }
                            }
                        }
                    }
        
    
}

mysqli_close($conn);
?>