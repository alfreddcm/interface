<?php
// update_user_status.php
include('user-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if lockerId and status are set in the POST data
    if (isset($_POST['lockerId']) && isset($_POST['status'])) {
        $lockerId = $_POST['lockerId'];
        $status = $_POST['status'];

        // Use a parameterized query to avoid SQL injection
        $updateStatusQuery = mysqli_prepare($conn, "UPDATE locker_data SET user_id = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($updateStatusQuery, "isi", $userId, $status, $lockerId);
        
        // Execute the query
        if (mysqli_stmt_execute($updateStatusQuery)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'lockerId or status not set in the POST data']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
