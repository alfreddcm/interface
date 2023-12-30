<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include ("../user-connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $emailToRemove = $_POST['email'];
        $emailToRemove = $conn->real_escape_string($emailToRemove);

        $sql = "DELETE FROM requestlist WHERE email = '$emailToRemove'";
        $result = $conn->query($sql);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to remove the email. ' . $conn->error]);
        }
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Email parameter not set']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
