<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();

    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

    if ($userId) {
        $filename = "../todo/{$userId}.txt";

        if (file_exists($filename)) {
            $todosJson = file_get_contents($filename);

            http_response_code(200);
            echo $todosJson;
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Todos file not found']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'User ID not found in session']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
