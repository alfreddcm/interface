<?php
// fetch_user_data.php

include('../user-connection.php');

if (isset($_POST['lockerid'])) {
    $lockerId = $_POST['lockerid'];

    $sql=mysqli_query($conn,"SELECT user_id, status from locker_data where id=$lockerId");
    if ($sql) {
        $row = mysqli_fetch_assoc($sql);
            if ($row) {
            $userId = $row['user_id'];
            $status = $row['status'];
            echo json_encode(['success' => true, 'userId' => $userId, 'status' => $status]);

        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);

        }
    } else {
        echo mysqli_error($conn);
    }

} else {
    echo json_encode(['status' => '']);
}
?>
