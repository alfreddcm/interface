<?php
include('../user-connection.php');
include('../php/php-admininfo.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$token = $_SESSION['token'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Locker</title>
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css" class="rel">
    <script src="../script.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../sweet/sweetalert2.all.min.js"></script>
    <script src="../sweet/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="../sweet/sweetalert2.css" class="rel">
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
                                <li><a class="dropdown-item" href="../admin/admin-profile.php">
                                        <img src="../icons/profile-icon.png" style="filter:invert(100)"> Profile</a></li>
                                <li><a class="dropdown-item" href="../php-logout.php">
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
        <a href="../admin/admin-userlist.php"><img src="../icons/users.png"> Manage users </a>
    </div>
    <div id="main">
        <div class="container mt-5">
        <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title"> Adding new card on <?php 
                                       
                    $sql = "SELECT * FROM department where id= $token";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row["dep_name"]
                    ?></h4>
                    <p class="card-text">
               
                    <div id="manage_users"></div>
                    </p>
                </div>
            </div>
        </div>
        <script>
       

            $(document).ready(function() {
                function updateManageUsers() {
                    $.ajax({
                        url: "../ard/manage_users_up.php",
                        data: {
                            token: '<?php echo $token; ?>'
                        },
                        method: 'POST',
                    }).done(function(data) {
                        $('#manage_users').html(data);
                    });
                }
                updateManageUsers();
                setInterval(updateManageUsers, 2000);
            });

            // dont touch ----->>>>----->>>>-----
            window.addEventListener("load", function() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update-device-mode.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send("device_mode=0");
            });

            window.addEventListener("beforeunload", function() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update-device-mode.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send("device_mode=1");
            });
        </script>
</body>
<style>
    .up_info1, .up_info2 {
  display: none;
  width: 270px;
  height: 40px;
  font-size: 17px;
  font-family: "Roboto", sans-serif;
  padding: 5px;
  margin-right: 20px;
  text-align: center;
  position: absolute;
}
</style>

</html>