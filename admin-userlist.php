<?php
include("user-connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: landing-page.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<title>Manage User</title>
<link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="sweet/sweetalert2.css" class="rel">
    <script src="sweet/jquery-1.10.2.min.js"></script>
    <script src="sweet/sweetalert2.all.min.js"></script>
</head>

<body>
    <header>
        <h2> <img src="icons/logo.png" srcset="" height="50px">
            ELOCKER</h2>
    </header>

    <div id="mySidebar" class="sidebar">
        <a class="openbtn" onclick="toggleNav()"><img src="icons/menu-icon.png" alt="" height="30px" width="30px"> <b>Menu</b></a>
        <a href="admin-dashboard.php"><img src="icons/dashboard-icon.png" height="30px" width="30px"> Dashboard</a>
        <a href="admin-profile.php"><img src="icons/profile-icon.png" height="30px" width="30px"> Profile</a>
        <a href="admin-lockerlist.php"><img src=" icons/locker.png" height="30px" width="30px"> Locker list</a>
        <a href="admin-userlist.php" style="background-color: white;"><img src="icons/users.png" height="30px" width="30px" style="filter:invert(100);"> <b style="color:black;">Manage users</b></a>
        <a href="php-logout.php"><img src="icons/logout-icon.png" height="30px" width="30px"> Log out</a>
    </div>

    <div id="main">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <?php
                $fetchuser = mysqli_query($conn, "SELECT * FROM user_data ORDER BY locker_id");
                while ($user = mysqli_fetch_assoc($fetchuser)) {
                    $userid = $user['id'];
                    $fetchlogscounts = mysqli_query($conn, "SELECT * FROM user_data AS us INNER JOIN Log_history AS lh ON us.locker_id = lh.locker_id WHERE us.id = $userid ");
                    $count = mysqli_num_rows($fetchlogscounts);
                ?>

                    <div class='col-sm-4 mb-1' style="font-size:13px; white-space: nowrap;">
                        <div class='card'>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src='uploads/<?php echo $user['user_profile'] ?>' class='card-img' alt='Locker Icon' id="imagePreview">
                                    <?php echo "<b class='num'>{$user['locker_id']}</b><br>"; ?>
                                </div>

                                <div class="col-md-6">
                                    <div class='card-body'>
                                        <?php
                                        echo "<p class='card-text'>";
                                        echo "User: {$user['fname']} {$user['mi']} {$user['lname']}<br>";
                                        echo "Email: " . $user['email'] . "<br>";
                                        echo "ID No: " . $user['idno'] . "<br>";

                                        echo "Access: $count<br>";
                                        echo "</p>";
                                        echo '<td>
                                        <a name="editbutton" id="editbutton" class="btn btn-primary editbutton p-2" data-email="' . $user['email'] . '" role="button">Edit</a>
                                        <a name="removeButton" id="removeButton" class="btn btn-danger remove-button p-2" data-email="' . $user['email'] . '" role="button">Remove</a>
                                    </td>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class='col-sm-4 mb-1' style="white-space: nowrap;">
                    <div class='card'>
                        <center>
                            <img src='icons/people.png' class='card-img' alt='Locker Icon' style="height: 150px; width:150px;">
                            <b class='num plus'>+</b>
                        </center>
                        <a href="add-user.php" class="text-center">
                            <button class="btn btn-primary">Add user</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- main /div -->


    <script src="script.js"></script>
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
                        url: 'php/remove-locker.php',
                        type: 'POST',
                        data: {
                            email: email
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire('Removed!', 'The User has been removed.', 'success');
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
        title: 'Update ' + email + ' information?',
        allowOutsideClick: true,
        showCancelButton: true,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    }).then((result) => {
        if (result.value) {
            Swal.fire('Updating...', 'Redirecting to edit page!', 'info');

            window.location.href = 'php/php-updateuser.php?email=' + encodeURIComponent(email);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // User clicked "Cancel"
            Swal.fire('Cancelled', 'Update operation cancelled', 'info');
        }
    });
});





    </script>
    <style>
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

        .card {
            overflow: hidden;
            height: 200px;
        }

        .row {
            margin-right: 0;
        }



        .num {
            outline-color: 1px solid black;
            position: absolute;
            text-align: right;
            top: 5rem;
            left: 5rem;
            color: white;
            font-size: 70px;
            text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;

        }

        .plus {
            top: 3rem;
            left: 13rem;

        }

        h6 {
            margin-top: 4px;
            padding: 10px;
            font-size: smaller;
        }

        #imagePreview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            /* Use 50% for a perfect circle */
            outline: 4px solid darkslateblue;
            outline-offset: .1px;
            display: block;
            margin: 25px 20px;
            /* Center the image horizontally */
        }
    </style>

</body>

</html>