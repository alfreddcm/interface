<?php
include('../user-connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $selectedCard = isset($_POST['selected_card']) ? $_POST['selected_card'] : null;

    if ($selectedCard !== null) {
        $uid = $selectedCard;
        $checkResult = mysqli_query($conn, "SELECT * FROM locker_data WHERE uid = '$uid'");

        if (!$checkResult) {
            echo "Error checking existing uuid: " . mysqli_error($mysqli);
        } else {
            $count = mysqli_fetch_row($checkResult);

            if ($count == 0) {
                $sql = "INSERT INTO locker_data (uid, token) VALUES (?, ?)";
                $sqlremove = "DELETE FROM newcard WHERE uid = ?";
                $stmt = mysqli_stmt_init($conn);
                $stmtr = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ss", $uid, $token);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    mysqli_stmt_prepare($stmtr, $sqlremove);
                    mysqli_stmt_bind_param($stmtr, "s", $uid);
                    mysqli_stmt_execute($stmtr);
                    mysqli_stmt_close($stmtr);

                    echo 'success';
                } else {
                    echo 'SQL Error';
                }
            } else {
                echo 'UID already on the list!';
            }
        }

        mysqli_close($conn);

    } else {
        echo 'Please Scan the card!';
    }
}
