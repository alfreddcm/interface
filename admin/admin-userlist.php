<?php
include("../user-connection.php");
include('../php/php-admininfo.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<title>Manage User</title>
<link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../sweet/sweetalert2.css" class="rel">
    <script src="../sweet/jquery-1.10.2.min.js"></script>
    <script src="../sweet/sweetalert2.all.min.js"></script>
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
        <a href="admin-dashboard.php"><img src="../icons/dashboard-icon.png"> Dashboard</a>
        <a href="admin-lockerlist.php"><img src="../icons/locker.png"> Locker list</a>
        <a href="admin-userlist.php" style="background-color: white; "><img src="../icons/users.png" style="filter:invert(100);"> <b style="color:black;"> Manage users</b></a>
    </div>



    <div id="main">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <h3 class="mb-2">User List</h3>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 gutters-sm ">
                    <?php
                    $fetchuser = mysqli_query($conn, "SELECT * FROM user_data where locker_id is not null ORDER BY locker_id");
                    while ($user = mysqli_fetch_assoc($fetchuser)) {
                        $userid = $user['id'];

                        // Modify the query to get the latest timestamp
                        $fetchlastaccess = mysqli_query($conn, "SELECT MAX(date_time) AS last_access FROM Log_history WHERE locker_id = '{$user['locker_id']}'");
                        $lastAccessResult = mysqli_fetch_assoc($fetchlastaccess);
                        $lastAccess = $lastAccessResult['last_access'];

                        $courseid = $user['course_id'];
                        $sqlcourse = mysqli_query($conn, "SELECT program FROM course WHERE id = $courseid ");
                        $course = mysqli_fetch_assoc($sqlcourse);
                    ?>

                        <div class="col mb-5 mt-4">
                            <div class="card ">
                                <?php echo "<b class='num'>{$user['locker_id']}</b><br>"; ?>
                                <div class="card-body text-center text">
                                    <img src="../uploads/<?php echo $user['user_profile'] ?>" alt="user" class="img-fluid img-thumbnail rounded-circle border-0 mb-3">
                                    <h5 class="card-title"> <?php echo "{$user['fname']} {$user['mi']}. {$user['lname']}"; ?> </h5>
                                    <p class="text-secondary"> <?php echo $user['email'] ?> </p><br>
                                    <p class="text-muted font-size-sm"><?php echo $user['idno'] ?></p><br>
                                    <p class="text-muted font-size-sm"><?php echo  $user['yrsec'] ?></p>
                                    <p class="text-muted font-size-sm"><?php echo  $course['program'] ?></p><br>

                                    <p class="text-muted font-size-sm"><?php echo "Last Access: " . ($lastAccess ? date('F j, Y g:i a', strtotime($lastAccess)) : 'Never') ?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group">

                                        <button type="button" class="btn btn-success dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="../icons/edit.png" alt="" height="20px"> Manage
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a name="editbutton" id="editbutton" class="editbutton dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Update User Info</a>
                                            </li>
                                            <li>
                                                <a name="changelocker" id="changelocker" class="changelocker dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Change Locker No</a>
                                            </li>
                                            <li>
                                                <a name="updatepass" id="updatepass" class="updatepass dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Reset Password</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a name="removeButton" id="removeButton" class="remove-button dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Remove</a>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <?php
            $fetchuser = mysqli_query($conn, "SELECT * FROM user_data where locker_id is null ORDER BY id");
            while ($user = mysqli_fetch_assoc($fetchuser)) {
                $userid = $user['id'];

                $fetchlastaccess = mysqli_query($conn, "SELECT MAX(date_time) AS last_access FROM Log_history WHERE locker_id = '{$user['locker_id']}'");
                $lastAccessResult = mysqli_fetch_assoc($fetchlastaccess);
                $lastAccess = $lastAccessResult['last_access'];

                $courseid = $user['course_id'];
                $sqlcourse = mysqli_query($conn, "SELECT program FROM course WHERE id = $courseid ");
                $course = mysqli_fetch_assoc($sqlcourse);
            ?>
            
                <div class="row justify-content-center align-items-center g-2">
                    <h3 class="mb-2">Unsigned Users</h3>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 gutters-sm">

                        <div class="col mb-5 mt-4">
                            <div class="card">
                                <?php echo "<b class='num'>{$user['locker_id']}</b><br>"; ?>
                                <div class="card-body text-center text">
                                    <img src="../uploads/<?php echo $user['user_profile'] ?>" alt="User" class="img-fluid img-thumbnail rounded-circle border-0 mb-3">
                                    <h5 class="card-title"> <?php echo "{$user['fname']} {$user['mi']}. {$user['lname']}"; ?> </h5>
                                    <p class="text-secondary"> <?php echo $user['email'] ?> </p><br>
                                    <p class="text-muted font-size-sm"><?php echo $user['idno'] ?></p><br>
                                    <p class="text-muted font-size-sm"><?php echo  $user['yrsec'] ?></p>
                                    <p class="text-muted font-size-sm"><?php echo  $course['program'] ?></p><br>

                                    <p class="text-muted font-size-sm"><?php echo "Last Access: " . ($lastAccess ? date('F j, Y g:i a', strtotime($lastAccess)) : 'Never') ?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group">

                                        <button type="button" class="btn btn-success dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="../icons/edit.png" alt="" height="20px"> Manage
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a name="editbutton" id="editbutton" class="editbutton dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Update User Info</a>
                                            </li>
                                            <li>
                                                <a name="changelocker" id="changelocker" class="changelocker dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Change Locker No</a>
                                            </li>
                                            <li>
                                                <a name="updatepass" id="updatepass" class="updatepass dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Reset Password</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a name="removeButton" id="removeButton" class="remove-button dropdown-item" data-email="<?php echo $user['email'] ?>" role="button">Remove</a>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
                    ?>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 12%; float:right; position: relative; ">
                    <div class="col ">
                        <a href="../php/add-user.php" class="text-center ">
                            <button class="btn btn-light addb"><img src="../icons/male-add-icon.png" alt=""> Add user</button>
                        </a>
                    </div>
                </div>
        </div>

        <!-- main /div -->

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../script.js"></script>
    <script>
        $(document).on('click', '.remove-button', function() {
            var email = $(this).data('email');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to remove the user: ' + email,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../php/remove-user.php',
                        type: 'POST',
                        data: {
                            email: email
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire('Removed!', 'The User has been removed.', 'success');
                            location.reload();
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to communicate with the server.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.editbutton', function() {
            var email = $(this).data('email');
            Swal.fire({
                title: '<h6>Update ' + email + ' information?<h6>',
                allowOutsideClick: true,
                showCancelButton: true,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            }).then((result) => {
                if (result.value) {
                    Swal.fire('Updating...', 'Redirecting to edit page!', 'info');

                    window.location.href = '../php/php-updateuser.php?email=' + encodeURIComponent(email);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Update operation cancelled', 'info');
                }
            });
        });


        $(document).ready(function() {
            $('.updatepass').click(function() {
                var email = $(this).data('email');
                Swal.fire({
                    title: 'Enter new password',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reset',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: (newPassword) => {
                        return $.ajax({
                            type: 'POST',
                            url: '../php/php-adminpassuser.php',
                            data: {
                                email: email,
                                password: newPassword
                            },
                            dataType: 'json',
                        }).then(response => {
                            if (response && response.status === 'success') {
                                return response;
                            } else {
                                throw new Error(response.message || 'An undefined error occurred.');
                            }
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Password updated successfully
                        Swal.fire('Password updated successfully!', '', 'success');
                    }
                }).catch((error) => {
                    // Handle AJAX or other errors
                    console.error('AJAX Error:', error);
                    Swal.fire('Error', 'An error occurred while processing the request.', 'error');
                });
            });
        });
    </script>
    <style>
        h3 {
            color: white;
            background: #253855b7;
            border-radius: 3px;
        }

        .img-thumbnail {
            width: 100px;
            margin-top: -65px;
            filter: drop-shadow(0 0 0.2rem black);
        }

        .container-lg {
            background-color: rgba(0, 0, 0, 0.223);
            width: 90%;
            height: fit-content;
            padding: 10px;
            padding-bottom: 30px;
            border-radius: 30px;
        }

        .modal-body {
            color: black;
        }

        #con {
            display: block;
            margin-left: 20px;
            padding: 0px;
        }

        .num {
            outline-color: 1px solid black;
            position: absolute;
            text-align: left;
            right: 15px;
            color: white;
            font-size: 70px;
            text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        }

        .dropdown .btn {
            color: #000;
        }

        .text {
            font-size: 13px;
        }

        /*  */
        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        .btn-light {
            color: #1a202c;
            background-color: #fff;
            border-color: #cbd5e0;
        }

        .ml-2,
        .mx-2 {
            margin-left: .5rem !important;
        }

        .card-header {
            display: flex;
            align-items: center;
        }

        .card-footer {
            background-color: #fff;
            border-top: 0 solid rgba(0, 0, 0, .125);
        }


        /*  */

        .addb {
            display: inline;
            position: fixed;
            right: 20px;
            bottom: 20px;
            color: black;
            background: white;
        }

        .addb :hover {

            right: 21px;
            bottom: 21px;
            color: black;
            background: gray;
        }

        .addb img {
            display: inline;
            width: 30px;
            height: 30px;
        }
    </style>

</body>
</div>
</div>

</html>