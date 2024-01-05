<?php

include("../user-connection.php");
include('../php/php-admininfo.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $lockerid = urldecode($_GET['id']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedUserId = $_POST['user'];
    $lid = $_POST['lid'];

    $checkUserQuery = "SELECT * FROM user_data WHERE id = $selectedUserId";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);

    if ($checkUserResult) {
        $userRow = mysqli_fetch_assoc($checkUserResult);

        if ($selectedUserId === 0) {
            $updateQuery = "UPDATE user_data SET locker_id = NULL WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'i', $selectedUserId);
            $updateResult = mysqli_stmt_execute($stmt);

            if (!$updateResult) {
                error_log("Error updating database: " . mysqli_error($conn));
                echo "Error updating database. Please try again.";
                exit();
            }

            echo "Updated";
            mysqli_close($conn);
            exit();
        } else {
            if ($userRow['locker_id'] == $lid) {
                echo "No changes needed.";
                exit();
            } else {
                $updateQuery = "UPDATE user_data SET locker_id = CASE 
                    WHEN id = $selectedUserId THEN $lid
                    WHEN id = (SELECT id FROM user_data WHERE locker_id = $lid LIMIT 1) THEN " . ($userRow['locker_id'] ? $userRow['locker_id'] : 'NULL') . "
                    ELSE locker_id
                END;";

                $updateResult = mysqli_query($conn, $updateQuery);

                if (!$updateResult) {
                    echo "Error updating database: " . mysqli_error($conn);
                    exit();
                }

                echo "Updated";
                mysqli_close($conn);
                exit();
            }
        }
    } else {
        echo "Error querying database: " . mysqli_error($conn);
        exit();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Locker List</title>
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../sweet/sweetalert2.css" class="rel">
    <script src="../sweet/jquery-1.10.2.min.js"></script>
    <script src="../sweet/sweetalert2.all.min.js"></script>
    <script src="../script.js"></script>
</head>

<body>
    <header class="text-start">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <a class="openbtn" onclick="toggleNav()"><img src="../icons/menu-icon.png" alt=""></a>
                <img src="../icons/logo.png" class="logo" height="30px">
                <h4 style="display: inline;">ELOCKER</h4>
            </div>
            <div class="col text-end">
                <div>
                    <div class="dropdown open">
                        <button class="btn dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <p class="font-weight-bold p1"><?php echo $fname . " " . $mi . ". " . $lname ?></p> &nbsp;
                            <img src="../adminuploads/<?php echo $profile ?>" alt="Admin" class="rounded-circle p">
                        </button>

                        <div class="dropdown-menu p-3" aria-labelledby="triggerId">
                            <p class="text-uppercase font-weight-bold"><?php echo $fname . " " . $mi . ". " . $lname ?></p>
                            <p class="text-secondary"> <?php echo $email ?>
                            <ul class="list-unstyled">
                                <li><a class="dropdown-item" href="admin-profile.php">
                                        <img src="../icons/profile-icon.png" style="filter:invert(100)"> Profile</a></li>
                                <li><a class="dropdown-item" href="../php/php-logout.php">
                                        <img src="../icons/logout-icon.png" style="filter:invert(100)">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <div id="mySidebar" class="sidebar">
        <a href="../admin/admin-dashboard.php"><img src="../icons/dashboard-icon.png"> Dashboard</a>
        <a href="../admin/admin-lockerlist.php" style="background-color: white; "><img src="../icons/locker.png" style="filter:invert(100);"> <b style="color:black;"> Locker list</b></a>
        <a href="../admin/admin-userlist.php"><img src="../icons/users.png"> Manage users</a>
    </div>
    <div id="main">
        <br>

        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">
                    <?php
                    echo "Locker ID: $lockerid";
                    $seluser = mysqli_query($conn, "SELECT * FROM locker_data AS ld left JOIN user_data AS ud ON ld.id = ud.locker_id WHERE ld.id = $lockerid");
                    if ($seluser) {
                        $row = mysqli_fetch_assoc($seluser);
                    } else {
                        echo "Query failed: " . mysqli_error($conn);
                    }
                    ?></h5>
                <p class="card-text text-black ">
                <table>
                    <tr>

                        <td class="text-end">Current User:</td>
                        <?php
                        if (!$seluser) {
                            echo  '<td class="text-start"> No user </td>';
                        } else {
                        ?>
                            <td class="text-start"><?php echo $row['fname'] . " " . $row['mi'] . ". " . $row['lname']." " .$row['idno']; ?></td>
                        <?php
                        }
                        ?>
                    </tr>
                </table>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-3">
                    <select class="form-select" id="user" name="user" required>
                        <?php

                        $sql = "SELECT * FROM user_data";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo '<option value="0"> Set to empty user</option>';

                            while ($row = $result->fetch_assoc()) {
                                $selected = ($selectedUserId == $row["id"]) ? 'selected' : '';
                                $optionValue = htmlspecialchars($row["id"]);
                                $fullName = htmlspecialchars($row["fname"] . " " . $row["mi"] . ". " . $row["lname"]);

                                if ($row['locker_id'] === null) {
                                    echo '<option value="' . $optionValue . '" ' . $selected . '>No Locker - ' . $fullName . ' ' . $row['idno'] . '</option>';
                                } else {
                                    echo '<option value="' . $optionValue . '" ' . $selected . '>' . "Locker: " . $row['locker_id'] . " " . $fullName . " " . $row['idno'] . '</option>';
                                }
                                                            }
                        } else {
                            echo '<option value="" disabled >No User data found</option>';
                        }
                        ?>
                    </select>
                    <input hidden type="text" value="<?php echo $lockerid; ?>" name="lid" id="lid">
                </form>
                <a name="" id="" class="btn btn-primary" href="../admin/admin-lockerlist.php" role="button">Return</a>
                <button id="submitBtn" class="btn btn-success" type="button">Submit</button>

                </p>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function submitForm() {
                var selectedUserId = $("#user").val();
                var lid = $("#lid").val();


                $.ajax({
                    type: "POST",
                    url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                    data: {
                        user: selectedUserId,
                        lid: lid,
                    },
                    success: function(response) {
                        console.log(response);

                        Swal.fire({
                            title: "Success",
                            text: "Updated successfully",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $lockerid; ?>";
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error",
                            text: "Error updating database: " + xhr.responseText,
                            icon: "error",
                            showCancelButton: false,
                            confirmButtonText: "OK",
                        });
                    },
                });
            }

            $("#submitBtn").on("click", function() {
                Swal.fire({
                    title: "Confirmation",
                    text: "Are you sure you want to update?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm();
                    }
                });
            });
        });
    </script>

</body>

</html>