<?php
include 'user-connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    
    // Add a new TODO item
    if (!empty($_POST['todo_text'])) {
        $todo_text = $_POST['todo_text'];
        $sql = "INSERT INTO todos (user_id, todo_text) VALUES (?, ?)";
        $stmt = $your_database_connection->prepare($sql);
        $stmt->bind_param('is', $user_id, $todo_text);
        $stmt->execute();
        $stmt->close();
    }

    // Delete existing TODO items
    if (!empty($_POST['completed'])) {
        $completed_ids = $_POST['completed'];
        foreach ($completed_ids as $todo_id) {
            $sql = "DELETE FROM todos WHERE id = ?";
            $stmt = $your_database_connection->prepare($sql);
            $stmt->bind_param('i', $todo_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Redirect back to the main page or handle as needed
header("Location: index.php");
exit();
?>
