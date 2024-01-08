<?php
include("php/php-userinfo.php");
include("php/php-update-profile.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="addcss.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <header>
        <h2> <img src="icons/logo.png" srcset="" height="50px">
            ELOCKER</h2>
    </header>

    <div id="mySidebar" class="sidebar">
        <a class="openbtn" onclick="toggleNav()"><img src="icons/menu-icon.png" alt="" height="30px" width="30px"> <b>Menu</b></a>
        <a href="user-dashboard.php"> <img src="icons/dashboard-icon.png" height="30px" width="30px"> Dashboard </a>
        <a href="user-profile.php" style="background-color: white; "><img src="icons/profile-icon.png" height="30px" width="30px" style="filter:invert(100);"><b style="color:black;"> Profile</b></a>
        <a href="php/php-logout.php"><img src="icons/logout-icon.png" height="30px" width="30px"> Log out</a>
    </div>

    <div id="main">
        <div class="container py-4">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-6 mb-1 mb-lg-0">
                    <div class="card mb-4" style="border-radius: .5rem;">
                        <div class="row g-2">
                            <div class="col-md-3 p-4 gradient-custom text-center text-black">
                                <img src="uploads/<?php echo $user_profile ?>" alt="Avatar" class="  my-3" id="imagePreview">
                                <hr>
                                <button type="button" class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#update">
                                    Update Details
                                </button>
                            </div>

                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Name</h6>
                                            <p class="text-muted"><?php echo $fname . " " . $mi . ". " . $lname ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?php echo $email ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Id Number</h6>
                                            <p class="text-muted">
                                                <?php
                                                echo $idno
                                                ?>
                                            </p>
                                        </div>
                                        

                                        <div class="col-6 mb-3">
                                            <div
                                                class="row justify-content-center align-items-center g-2"
                                            >
                                                <div class="col"><h6>Sex</h6>
                                            <p class="text-muted">
                                                <?php
                                                echo $sex
                                                ?>
                                            </p></div>
                                                <div class="col"><h6>Year Section</h6>
                                            <p class="text-muted">
                                                <?php
                                                echo $yrsec
                                                ?>
                                            </p></div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Course</h6>
                                            <p class="text-muted">
                                                <?php
                                                $sqlcourse = mysqli_query($conn, "SELECT program from course where id=$course_id");
                                                $row = mysqli_fetch_assoc($sqlcourse);
                                                $courseProgram = $row['program'];
                                                echo $courseProgram;
                                                ?>
                                            </p>
                                        </div>
                                        <div class="col-6 mb-3">
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
                            <a href="user-updatephoto.php">
                                <button type="button" class="btn mb-2 btn-primary">Edit photo</button></a>
                            <button type="button" class="btn mb-2 q btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">Edit Information</button>
                            <a href="user-updatepass.php"><button class="btn mb-2  btn-primary">Update Password</button></a>
                        </i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var modalId = document.getElementById('modalId');

        modalId.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget;
            let recipient = button.getAttribute('data-bs-whatever');
        });
    </script>


    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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

                                    <div class="form-group">
                                        <label for="idno">ID Number</label>
                                        <input type="text" class="form-control" id="idno" name="idno" placeholder="Enter ID Number" maxlength="7" oninput="addHyphenidno()" value="<?php echo $idno ?>" required>
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

                                    <div class="mb-3">
                                        <label>Year and Section</label>
                                        <input type="text" class="form-control" id="ysec" name="ysec" placeholder="eg. 2-1" maxlength="3" oninput="addHyphen()" value="<?php echo $yrsec ?>" required>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Course</label>
                                                <select class="form-select" id="course" name="course" required>
                                                    <?php
                                                    $sql = "SELECT id, program FROM course";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        echo '<option value="" selected>Select a Course</option>';

                                                        while ($row = $result->fetch_assoc()) {
                                                            $selected = ($course_id == $row["id"]) ? 'selected' : '';
                                                            echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["program"] . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="" disabled>No department found</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="department_id">Department ID</label>
                                                <?php
                                                $sql = "SELECT id, dep_name FROM department";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    echo '<select class="form-select" id="depid" name="depid" required>';

                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = ($department_id == $row["id"]) ? 'selected' : '';
                                                        echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["dep_name"] . '</option>';
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
                            </div>
                            <center class="mt-2">
                                <button type="submit" class="btn btn-info ">Submit</button>
                            </center>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="script.js"></script>
<style>
    #imagePreview {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 100%;
        outline: 4px solid darkslateblue;
        outline-offset: 2px;
        margin-bottom: -40px;
    }



    @media screen and (max-width: 600px) {
        .col-lg-6 {
            flex: 0 0 auto;
            width: 80%;
        }

        #main {
            margin: 1px;
            padding-right: 2px;
        }
        .card{
            width: 100%;
            margin-right: 0;
        }
    }

    .col-xl-6 {
        flex: 0 0 auto;
        width: 80%;
    }
</style>

</html>