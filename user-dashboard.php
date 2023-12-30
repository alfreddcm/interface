<?php
include("php/php-userinfo.php");
function time_elapsed_string($datetime)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff_str = array(
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($diff_str as $key => &$value) {
        if ($diff->$key) {
            $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
        } else {
            unset($diff_str[$key]);
        }
    }

    return $diff_str ? implode(', ', $diff_str) . ' ago' : 'just now';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/todolist.js"></script>

</head>

<body>

    <header>
        <h2> <img src="icons/logo.png" srcset="" height="50px">
            ELOCKER</h2>
    </header>

    <div id="mySidebar" class="sidebar">
        <a class="openbtn" onclick="toggleNav()"><img src="icons/menu-icon.png" alt="" height="30px" width="30px">
            <b>Menu</b></a>

        <a href="User-dashboard.php" style="background-color: white; "><img src="icons/dashboard-icon.png" height="30px" width="30px" style="filter:invert(100);"><b style="color:black;"> Dashboard</b></a>
        <a href="user-profile.php"><img src="icons/profile-icon.png" height="30px" width="30px"> Profile</a>
        <a href="php/php-logout.php"><img src="icons/logout-icon.png" height="30px" width="30px"> Log out</a>
    </div>


    <div id="main">
        <div class="container">
            <div class="row justify-content-center align-items-center top g-1">
                <div class="col-lg-6 ">
                    <div class="card d">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-4">
                                    <img src="uploads/<?php echo $user_profile ?>" id="imagePreview" class="img-fluid">
                                </div>
                                <div class="col-sm-8">
                                    <p class="text-uppercase font-weight-bold mb-1"><?php echo $fname . " " . $mi . ". " . $lname ?></p>
                                    <p class="text-secondary mb-1"><?php echo $email ?></p>
                                    <p class="text-muted font-size-sm"><?php
                                                                        $sqldep = mysqli_query($conn, "SELECT dep_name from department where id=$department_id");
                                                                        $row = mysqli_fetch_assoc($sqldep);
                                                                        $sqldep = $row['dep_name'];
                                                                        echo $sqldep;
                                                                        ?></p>
                                    <a href="user-profile.php" class="btn btn-outline-primary">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row justify-content-center align-items-center g-1">
                        <div class="col-md-6 ">
                            <div class="card justify-content-center align-items-center">
                                <div class="card-body">
                                    <h3 class="text-center">Locker <br>
                                        <b class="number text-center"><?php
                                                                        $lockerno = mysqli_query($conn, "SELECT id FROM locker_data WHERE user_id = " . $id);
                                                                        $row = mysqli_fetch_assoc($lockerno);
                                                                        echo $row["id"];
                                                                        ?></b>
                                    </h3>
                                    <div class="">
                                        <button type="button" name="" id="" class="btn btn-primary">
                                            UNLOCK
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card d">
                                <div class="card-body">
                                    <center>
                                        <h1 class="card-text loader">
                                            <h5>Access Count Today</h5>
                                            <b class="number">
                                                <?php
                                                $today_start = date("Y-m-d 00:00:00");
                                                $today_end = date("Y-m-d 23:59:59");
                                                $sqlacc = mysqli_query($conn, "SELECT * FROM log_history WHERE locker_id = $locker_id AND date_time BETWEEN '$today_start' AND '$today_end'");
                                                $count = mysqli_num_rows($sqlacc);
                                                echo $count;
                                                ?>
                                            </b>
                                        </h1>
                                        <p class="card-text"><small class="text-muted">
                                                <?php
                                                $last_access = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(date_time) AS last_access FROM log_history WHERE locker_id = $locker_id"));
                                                echo "Last updated " . time_elapsed_string($last_access['last_access']) . " ago";
                                                ?>
                                            </small></p>
                                    </center>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg-6 scroll">
                    <div class="card text-start">
                        <div class="card-body">
                            <h6><img src="icons/project-icon.png" height="20px"> Activities</h6>
                            <hr>
                            <p class="card-text">
                            <table class="table ">

                                <?php
                                $showhistory = mysqli_query($conn, "SELECT * FROM log_history WHERE locker_id = $locker_id ORDER BY date_time DESC");

                                $currentDay = '';
                                if ($showhistory->num_rows > 0) {
                                    while ($row = $showhistory->fetch_assoc()) {
                                        $formattedDate = date('F j, Y', strtotime($row["date_time"])); // Format "December 4th 2023"
                                        $formattedTime = date('h:i A', strtotime($row["date_time"])); // Format "12:00 PM"

                                        $dayText = '';
                                        if (date('Y-m-d') == date('Y-m-d', strtotime($row["date_time"]))) {
                                            $dayText = 'Today';
                                        } elseif (date('Y-m-d', strtotime('yesterday')) == date('Y-m-d', strtotime($row["date_time"]))) {
                                            $dayText = 'Yesterday';
                                        }

                                        echo "<tr>";
                                        echo "<td scope='row'>$dayText</td>";
                                        echo "<td>" . $formattedDate . "</td>";
                                        echo "<td>" . $formattedTime . "</td>";
                                        echo "<td>" . $row['access'] . "</td>";

                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'> No data found</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>

                        </div>
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 scroll">
                    <div class="card">
                        <div class="card-body">
                            <h6><img src="icons/project-icon.png" height="20px"> To do</h6>
                            <hr>
                            <div class="add-items d-flex">
                                <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                                <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
                            </div>
                            <div class="list-wrapper">
                                <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">Pe Uniform </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked>Call John </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">Create Reviewer </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">Shoes </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked>Prepare for presentation </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox">Note on the box </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <style>
            .scroll{
                height: auto;
            }
            .scroll .card{
                height: 300px;
            }
            .list-wrapper input[type=checkbox] {
                margin-right: 4px;
            }

            .col-lg-6 .card {
                max-height: 300px;
                overflow-y: auto;
            }

            .top .card {
                height: 200px;
            }

            .modal-body {
                color: black;
            }

            #con {
                display: block;
                margin-left: 20px;
                padding: 0px;
            }

            .user {
                width: fit-content;
            }

            #imagePreview,
            #imageP {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 100%;
            }

            .gradient-custom {
                background: #f6d365;
                background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

                background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
            }

            @media screen and (max-width: 600px) {
                .col-lg-6 {
                    flex: 0 0 auto;
                    width: 80%;
                }
            }



            * {
                margin: 0;
                padding: 0
            }

            .card {
                margin: 9px;
            }

            .name {
                font-size: 22px;
                font-weight: bold
            }

            .number {
                font-size: 60px;
                font-weight: bold
            }


            .text span {
                font-size: 13px;
                color: #545454;
                font-weight: 500
            }

            .icons i {
                font-size: 19px
            }
        </style>
</body>

</html>