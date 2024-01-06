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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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

            <div class="row justify-content-start align-items-start g-1">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">

                            <h3 class="mb-2">Good Day, <b><?php echo $fname . " " . $mi . ". " . $lname ?></b>!</h3>
                            <div class="row justify-content-start align-items-start g-1">
                                <div class="col-sm-3">
                                    <center>
                                        <img src="uploads/<?php echo $user_profile ?>" style="max-width: 150px;border-radius:50%; object-fit: cover;
" alt="">
                                    </center>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Year Section: </label><br>
                                    <label for="">Course: </label><br>
                                    <label for="">Year Section: </label>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">Locker <br>
                                <b class="number text-center"><?php
                                                                $lockerno = mysqli_query($conn, "SELECT ld.id FROM locker_data as ld inner join user_data as ud 
                                                                        on ld.id=ud.locker_id WHERE ud.id = " . $id);
                                                                $row = mysqli_fetch_assoc($lockerno);
                                                                echo $row["id"];
                                                                ?></b>
                            </h4>
                            Today access: <?php
                                            $today_start = date("Y-m-d 00:00:00");
                                            $today_end = date("Y-m-d 23:59:59");
                                            $sqlacc = mysqli_query($conn, "SELECT * FROM log_history WHERE locker_id = $locker_id AND date_time BETWEEN '$today_start' AND '$today_end'");
                                            $count = mysqli_num_rows($sqlacc);
                                            echo $count;
                                            ?>
                            <br>
                            <p class="card-text"><small class="text-muted">
                                    <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $last_access = mysqli_fetch_assoc(mysqli_query($conn, "SELECT max(date_time) AS last_access FROM log_history WHERE locker_id = $locker_id"));
                                    echo "Last updated " . time_elapsed_string($last_access['last_access']);
                                    ?>
                                </small></p>
                        </div>

                    </div>

                </div>
            </div>


            <div class="row justify-content-start align-items-start g-1">
                <div class="col scroll">
                    <div class="card">
                        <h6 class="card-header"><img src="icons/project-icon.png" height="20px"> To do </h6>
                        <hr>

                    </div>
                </div>

                <div class="col scroll">
                    <div class="card text-start" style="overflow-y:scroll">
                        <h6 class="card-header"><img src="icons/project-icon.png" height="20px"> Activities</h6>
                        <table class="table">

                            <?php
                            $showhistory = mysqli_query($conn, "SELECT * FROM log_history WHERE locker_id = $locker_id ORDER BY date_time DESC");

                            $currentDate = '';
                            if ($showhistory->num_rows > 0) {
                                while ($row = $showhistory->fetch_assoc()) {
                                    $formattedDate = date('F j, Y', strtotime($row["date_time"]));
                                    $formattedTime = date('h:i A', strtotime($row["date_time"]));

                                    if ($formattedDate != $currentDate) {
                                        echo "<tr><td colspan='4'>$formattedDate</td></tr>";
                                        $currentDate = $formattedDate;
                                    }

                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td>$formattedTime</td>";
                                    echo "<td>" . $row['access'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'> No data found</td></tr>";
                            }
                            ?>
                        </table>

                    </div>
                </div>
                <div class="col">



                    <div class="card text-start">
                        <h6 class="card-header"><img src="icons/project-icon.png" height="20px"> Locker Usage</h6>
                        <div class="card-body">
                            <?php

                            echo '
                            <div class="row justify-content-center align-items-center g-2">
                            ';

                            echo ' 
                            <div class="col">
                            <label for="selectMonth">Select Month:</label>
                            <select id="selectMonth" class="form-select">';
                            for ($i = 1; $i <= 12; $i++) {
                                $month = date('F', mktime(0, 0, 0, $i, 1));
                                echo '<option value="' . date("Y-m", mktime(0, 0, 0, $i, 1)) . '">' . $month . '</option>';
                            }
                            echo '</select>   
                            </div>
                            ';

                            echo '<div class="col">


                            <label for="selectYear">Select Year:</label>
                            <select id="selectYear" class="form-select">
                             
                            
                            ';


                            $yearRange = range(date("Y"), date("Y") - 5); // Change the range as needed
                            foreach ($yearRange as $year) {
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            }
                            echo '</select>
                                         </div>
                                    </div>';

                            $selectedMonth = date("Y-m"); // Change this to the desired month (e.g., "2024-01")
                            $selectedYear = date("Y"); // Change this to the desired year (e.g., "2024")

                            $logHistoryData = array();
                            $logHistoryQuery = "SELECT DATE(date_time) as day, COUNT(*) as usage_count 
                                                    FROM log_history 
                                                    WHERE locker_id = $locker_id 
                                                    AND DATE_FORMAT(date_time, '%Y-%m') = '$selectedMonth'
                                                    AND YEAR(date_time) = $selectedYear
                                                    GROUP BY day 
                                                    ORDER BY day DESC";
                            $logHistoryResult = mysqli_query($conn, $logHistoryQuery);

                            while ($row = mysqli_fetch_assoc($logHistoryResult)) {
                                $logHistoryData['labels'][] = $row['day'];
                                $logHistoryData['data'][] = $row['usage_count'];
                            }
                            ?>
                            <canvas id="lockerUsageChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>







</body>
<script src="script.js"></script>
<script src="todo/script.js"></script>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script>
    // Use the data fetched from the server
    var lockerUsageData = {
        labels: <?php echo json_encode($logHistoryData['labels']); ?>,
        datasets: [{
            label: 'Locker Usage',
            data: <?php echo json_encode($logHistoryData['data']); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    // Initialize the chart
    var ctx = document.getElementById('lockerUsageChart').getContext('2d');
    var lockerUsageChart = new Chart(ctx, {
        type: 'line',
        data: lockerUsageData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('selectMonth').addEventListener('change', updateChart);
    document.getElementById('selectYear').addEventListener('change', updateChart);

    function updateChart() {
        var selectedMonth = document.getElementById('selectMonth').value;
        var selectedYear = document.getElementById('selectYear').value;

        $.ajax({
            url: 'fetch_data.php',
            method: 'POST',
            data: {
                selectedMonth: selectedMonth,
                selectedYear: selectedYear
            },
            success: function(response) {
                var data = JSON.parse(response);
                lockerUsageChart.data.labels = data.labels;
                lockerUsageChart.data.datasets[0].data = data.data;
                lockerUsageChart.update();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }
</script>


<style>
    .card-header {
        background-color: #f5f5f5;
        /* Change the background color as needed */
        padding: 10px;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .scroll {
        height: auto;
    }

    .scroll .card {
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


    .gradient-custom {
        background: #f6d365;
        background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

        background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
    }

    @media screen and (max-width: 600px) {

        /* .col-lg-6 {
            flex: 0 0 auto;
            width: 90%;
            padding: auto;
        } */
        #main {
            margin: 0;
            margin-left: 20px;
        }

        #main .card {
            font-size: 12px;
        }

        .card {
            width: 350px;
        }
    }

    h3 {
        color: white;
        background: #253855b7;
        border-radius: 3px;
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

</html>