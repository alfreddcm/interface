<?php
include('../user-connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a valid database connection ($conn)

    // Retrieve the token and other form data
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $selectedCard = isset($_POST['selected_card']) ? $_POST['selected_card'] : null;

    // Check if $selectedCard is not null
    if ($selectedCard !== null) {
        // Assuming the UID is the same as the selected card ID
        $uid = $selectedCard;
        $checkQuery = "SELECT COUNT(*) FROM locker_data WHERE uid = '$uid'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (!$checkResult) {
            echo "Error checking existing uuid: " . mysqli_error($mysqli);
        } else {
            $count = mysqli_fetch_row($checkResult)[0];

            if ($count == 0) {
                // Insert data into the locker_data table
                $sql = "INSERT INTO locker_data (uid, token) VALUES (?, ?)";
                $sqlremove = "DELETE FROM newcard WHERE uid = ?";
                $stmt = mysqli_stmt_init($conn);
                $stmtr = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ss", $uid, $token);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    // Remove from newcard table
                    mysqli_stmt_prepare($stmtr, $sqlremove);
                    mysqli_stmt_bind_param($stmtr, "s", $uid);
                    mysqli_stmt_execute($stmtr);
                    mysqli_stmt_close($stmtr);

                    echo '<script>alert("Added!"); window.location.href="../php/add-locker.php"; </script>';
                } else {
                    echo '<p class="alert alert-danger">SQL Error</p>';
                }
            } else {
                // 'uuid' already exists, handle accordingly
                echo '<script>alert("Duplicate uid found!"); window.location.href="../php/add-locker.php"; </script>';
            }
        }

        // Close the database connection if needed
        mysqli_close($conn);

    } else {
        echo ' <script>alert("Please select a card."); window.location.href="../php/add-locker.php";</script>';
    }
}
