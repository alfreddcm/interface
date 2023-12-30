<?php

include("../user-connection.php");

if (isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    $sql = mysqli_query($conn, "SELECT * FROM user_data WHERE email = '$email'");
    if ($row = mysqli_fetch_assoc($sql)) {

        $userid = $row['id'];
        $user_profile = $row['user_profile'];
        $idno = $row['idno'];
        $fname = $row['fname'];
        $mi = $row['mi'];
        $lname = $row['lname'];
        $sex = $row['sex'];
        $pass = $row['password'];
        $course_id = $row['course_id'];
        $department_id = $row['department_id'];
        $yrsec = $row['yrsec'];
    } else {
        echo 'Error retrieving user data!';
    }
} else {
    // Redirect or handle the case where the email parameter is not set
    header("Location: error.php");
    exit();
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Edit User</title>
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="../script.js"></script>
    <link rel="stylesheet" href="../sweet/sweetalert2.css" class="rel">
    <script src="../sweet/sweetalert2.all.min.js"></script>
    <script src="../sweet/jquery-1.10.2.min.js"></script>
</head>

<body>
    <header class="text-start">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <a class="openbtn" onclick="toggleNav()"><img src="../icons/menu-icon.png" alt=""></a>
                <img src="../icons/logo.png" class="logo" height="30px">
                <h4 style="display: inline;">ELOCKER</h4>
            </div>
        </div>

    </header>

    <div id="mySidebar" class="sidebar">
        <a href="../admin/admin-dashboard.php"><img src="../icons/dashboard-icon.png"> Dashboard</a>
        <a href="../admin/admin-lockerlist.php"><img src="../icons/locker.png"> Locker list</a>
        <a href="../admin/admin-userlist.php" style="background-color: white; "><img src="../icons/users.png" style="filter:invert(100);"> <b style="color:black;"> Manage users</b></a>
    </div>
    <div id="main">

        <div class="container">
            <div class="card ">
                <div class="card-header">
                    Edit User Profile
                </div>
                <div class="p-4">
                    <form id="updateForm" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo $userid; ?>">

                        <div class="col">
                            <div class="form-group ">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" autocomplete="email">
                            </div>

                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label for="mi">Middle Initial</label>
                                        <input type="text" class="form-control" id="mi" name="mi" value="<?php echo $mi; ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $lname; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="idno">ID number</label>
                                        <input type="text" class="form-control" id="idno" name="idno" value="<?php echo $idno; ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="sex">Sex</label>
                                    <select class="form-control" id="sex" name="sex">
                                        <option value="m" <?php echo ($sex == 'male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="f" <?php echo ($sex == 'female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="yrsec">Year and Section</label>
                                        <input type="text" class="form-control" id="yrsec" nmaxlength="3" name="yrsec" value="<?php echo $yrsec; ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="course">Course ID</label>
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
                                        <label for="depid">Department ID</label>
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

                                <div class="row text-center g-2">
                                    <div class="col text-end">
                                        <a href="../admin/admin-userlist.php"> <button type="button" class="btn btn-secondary">
                                                Return
                                            </button></a>
                                    </div>
                                    <div class="col text-start">
                                        <button type="submit" class="btn btn-success">Save Changes</button>

                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
<script>
    $(document).ready(function() {
        $('#updateForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: 'POST',
                url: 'php-updateuser1.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response && response.status === 'success') {
                        // Handle success
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                    } else {

                        var errorMessage = response && response.message ? 'Error: ' + response.message : 'An undefined error occurred.';
                        console.error(errorMessage);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Log detailed error information to the console
                    console.error('AJAX Error:', textStatus, errorThrown);
                    console.log('Server Response:', jqXHR.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing the request.',
                    });
                }
            });
        });
    });
</script>


<style>
    @media screen and (max-width: 600px) {
        .container .card {
            width: 100%
        }
    }
</style>

</html>