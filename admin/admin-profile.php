<?php
include("../user-connection.php");
include("../php/php-admininfo.php");
include("../php/php-updateadminprofile.php");
?>
<!doctype html>
<html lang="en">

<head>
    <title>Profile</title>
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../style.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                                <li><a class="dropdown-item" href="#" onclick="confirmLogout();">
                                        <img src="../icons/logout-icon.png" style="filter:invert(100)">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="mySidebar" class="sidebar">
        <a href="admin-dashboard.php" style="background-color: white; "><img src="../icons/dashboard-icon.png" style="filter:invert(100);"><b style="color:black;"> Dashboard</b></a>
        <a href="admin-lockerlist.php"><img src="../icons/locker.png"> Locker list</a>
        <a href="admin-userlist.php"><img src="../icons/users.png"> Manage users</a>
    </div>

    <div id="main">
        <div class="container py-4">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-6 mb-1 mb-lg-0">
                    <div class="card mb-4" style="border-radius: .5rem;">
                        <div class="row g-2">
                            <div class="col-md-4 mb-0 gradient-custom text-center text-black">
                                <img src="../adminuploads/<?php echo $profile ?>" alt="Avatar" class="img-fluid my-3" id="imagePreview">
                                <hr>
                                <h6><button type="button" class="btn btn-success btn-m" data-bs-toggle="modal" data-bs-target="#update">
                                        Update info
                                    </button></h6>
                            </div>

                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <h6>Name</h6>
                                        <p class="text-muted"><?php echo $fname . " " . $mi . ". " . $lname ?></p>

                                        <h6>Email</h6>
                                        <p class="text-muted"><?php echo $email ?></p>
                                        <h6>Position</h6>
                                        <p class="text-muted"><?php echo ucfirst(strtolower($pos)); ?></p>

                                        <h6>Department</h6>
                                        <p class="text-muted">
                                            <?php
                                            $sqldep = mysqli_query($conn, "SELECT dep_name from department where id=$department_id");
                                            $row = mysqli_fetch_assoc($sqldep);
                                            $sqldep = $row['dep_name'];
                                            echo $sqldep;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>


    <div class="modal fade text-center" id="update" tabindex="1" role="dialog" aria-labelledby="up" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="up">
                        Update </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <i class=" text-center">
                            <a href="admin-updatephoto.php">
                                <button type="button" class="btn mb-2 btn-primary">Edit photo</button></a>
                            <button type="button" class="btn mb-2 q btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">Edit Information</button>
                            <a href="admin-updatepass.php"><button class="btn mb-2  btn-primary">Update Password</button></a>
                            <a href="add-admin.php"><button class="btn mb-2  btn-primary">Add Administrator</button></a>
                        </i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Update User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid center-container">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $email ?>">
                                    </div>


                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fname">First Name</label>
                                                <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" pattern="[a-zA-Z]*" title="Must contain a-z characters" value="<?php echo $fname ?>">
                                            </div>

                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="mi">MI</label>
                                                <input type="text" class="form-control" id="mi" name="mi" placeholder="Enter middle initial" pattern="[a-zA-Z]*" title=" Must contain a-z characters" value="<?php echo $mi ?>" maxlength="1">
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="lname">Last Name</label>
                                                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $lname ?>" placeholder="Enter last name" pattern="[a-zA-Z]*" title="Must contain a-z characters" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="sex">Sex</label>
                                        <select class="form-select" id="sex" name="sex" required>
                                            <?php
                                            if ($sex == "m") {
                                                echo "<option value='" . $sex . "'>Male </option>";
                                                echo "<option value='f'>Female</option>";
                                            } else {
                                                echo "<option value='" . $sex . "'>Female</option>";
                                                echo "<option value='m'>Male</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="row justify-content-center align-items-center g-2">
                                        <label for="sex">Position</label>
                                        <select class="form-select" id="pos" name="pos" required>
                                            <?php
                                            if ($pos == "student") {
                                                echo "<option value='" . $pos . "'>Student </option>";
                                                echo "<option value='instructor'>Instructor</option>";
                                            } else {
                                                echo "<option value='" . $pos . "'>Intructor</option>";
                                                echo "<option value='student'>Student</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <?php
                                            $sql = "SELECT id, dep_name FROM department";
                                            $result = $conn->query($sql);
                                            $sql2 = "SELECT id, dep_name FROM department where id=$department_id";
                                            $result2 = $conn->query($sql2);
                                            $dep = $result2->fetch_assoc();

                                            if ($result->num_rows > 0) {
                                                echo '<select class="form-select" id="depid" name="depid" required>';
                                                echo '<option value="' . $dep['id'] . '" selected>' . $dep['dep_name'] . '
                                                            
                                                            </option>';
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["id"] . '">' . $row["dep_name"] . '</option>';
                                                }
                                                echo '</select>';
                                            } else {
                                                echo '<p>No department found</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </center>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <footer>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script>


        var modalId = document.getElementById('modalId');

        modalId.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget;
            let recipient = button.getAttribute('data-bs-whatever');
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../php/php-logout.php';
                }
            });
        }

        
    </script>
</body>
<style>
    #imagePreview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 100%;
        outline: 4px solid darkslateblue;
        outline-offset: 2px;
        margin-bottom: -40px;
    }

    .card {
        padding: 20px;
        height: fit-content;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @media screen and (max-width: 600px) {
        .card {
            overflow-x: scroll;
            height: 80%;
            width: 80%;
        }
    }
</style>

</html>