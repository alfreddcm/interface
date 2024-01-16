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
                $sql = "SELECT * FROM locker_data WHERE uid = $card_uid";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    echo "SQL_Error_Select_card: " . mysqli_error($conn);
                    exit();
                }

                if ($row = mysqli_fetch_assoc($result)) {
                    $lockerid = $row['id'];
                    $checkLockerQuery = "SELECT * FROM locker_data as ld INNER JOIN user_data as ud ON ld.id = ud.locker_id WHERE ld.id = '$lockerid' AND ud.locker_id IS NOT NULL";

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
                            echo "Log" . $lockerid . "Open";
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
                            echo "Log" . $lockerid . "Close";
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
                            echo "Log" . $lockerid . "Open";
                        }
                    } else {
                        echo "Not Assigned";
                    }
                } else {
                    echo "Not Registered";
                    exit();
                }
            } else if ($device_mode == 0) {

                $UIDresult = $_GET["card_uid"];
                $Write = "<?php $" . "UIDresult='" . $UIDresult . "'; " . "echo $" . "UIDresult;" . " ?>";
                
                // Specify the file path
                $filePath = '../UIDContainer.php';
                
                // Use file_put_contents with error handling
                if (file_put_contents($filePath, $Write) !== false) {
                    echo 'Posted'.$UIDresult;
                } else {
                    echo 'error';
                
                    // Output additional error information
                    if (file_exists($filePath)) {
                        echo ' Check file permissions.';
                    } else {
                        echo ' File not found. Check if the file path is correct.';
                    }
                }
                             
            }
                            }
                    }
        
    
}

mysqli_close($conn);
?>