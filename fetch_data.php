<?php
// fetch_data.php

include 'php/php-userinfo.php';

if (isset($_POST['selectedMonth']) && isset($_POST['selectedYear'])) {
    $selectedMonth = $_POST['selectedMonth'];
    $selectedYear = $_POST['selectedYear'];

    // Your existing database query code
    $logHistoryQuery = "SELECT DATE(date_time) as day, COUNT(*) as usage_count 
                       FROM log_history 
                       WHERE locker_id = ? 
                       AND DATE_FORMAT(date_time, '%Y-%m') = ?
                       AND YEAR(date_time) = ?
                       GROUP BY day 
                       ORDER BY day DESC";

    $stmt = mysqli_prepare($conn, $logHistoryQuery);
    mysqli_stmt_bind_param($stmt, "iss", $locker_id, $selectedMonth, $selectedYear);
    mysqli_stmt_execute($stmt);
    $logHistoryResult = mysqli_stmt_get_result($stmt);

    $logHistoryData = array();

    while ($row = mysqli_fetch_assoc($logHistoryResult)) {
        $logHistoryData['labels'][] = $row['day'];
        $logHistoryData['data'][] = $row['usage_count'];
    }

    // Output the data in JSON format
    echo json_encode($logHistoryData);
} else {
    echo 'Invalid request';
}
?>
