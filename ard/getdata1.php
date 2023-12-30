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
                //logging
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
                        //*****************************************************
                        //if card is in the list already
                        $userid = $row['id'];
                        $insertlog = "INSERT INTO Log_history (locker_id, date_time, access) VALUES (?, CURDATE(), 'RFID')";
                        $insres = mysqli_stmt_init($conn);
                        mysqli_stmt_bind_param($insres, "s", $$userid);
                        mysqli_stmt_execute($insres);
                        echo "logged". $userid;
                    } else {
                        echo "Not found!";
                        exit();
                    }
                }
            } else if ($device_mode == 0) {
                $sql = "SELECT * FROM locker_data WHERE uid=?";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {

                    mysqli_stmt_bind_param($stmt, "i", $card_uid);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        echo "Already on list";
                    } else {

                        $insert = "INSERT INTO newcard (uid) values $card_uid";
                        if (mysqli_query($conn, $insert)) {
                            echo "available!";
                        }

                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Statement preparation failed.";
                }

                mysqli_close($conn);
            } else {

            }
        }
    }
} else {
    //get dece status
}
