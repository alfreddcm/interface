<?php
include("../php/php-admininfo.php");


// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['psw'];
    $newPassword = $_POST['newpsw'];
    $confirmPassword = $_POST['confirmpassword'];

    $uppercase = preg_match('@[A-Z]@', $newPassword);
    $lowercase = preg_match('@[a-z]@', $newPassword);
    $number = preg_match('@[0-9]@', $newPassword);

    $email = mysqli_real_escape_string($conn, $_SESSION['email']);

    $slqf = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    $sqldata = mysqli_fetch_assoc($slqf);

    if ($slqf) {
        $affectedRows = mysqli_affected_rows($conn);
        if ($affectedRows > 0) {
            $oldPassword = $sqldata['password'];
            if (!password_verify($password, $oldPassword)) {
                echo 'Current password doesn\'t match';
                exit();
            } elseif (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
                echo 'Password should be at least 8 characters in length and include at least one uppercase letter, one lowercase letter, one number, and one special character.';
                exit();
            } elseif ($newPassword != $confirmPassword) {
                echo 'Invalid confirm password';
                exit();
            } else {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $userId = $sqldata['id'];
                $updateQuery = "UPDATE admin SET password = '$hashedNewPassword' WHERE id = '$userId'";
                mysqli_query($conn, $updateQuery);

                echo 'success';
                exit();

            }
        } else {
            echo "Update did not affect any rows.";
        }
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Password</title>
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../addcss.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="../script.js"></script>
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
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Password</h4>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="passwordForm" method="post">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" id="psw" placeholder="Password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                <i id="err1"></i>
                                <span class="error" id="PasswordError" style="color: red;"></span>

                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" id="newpsw" placeholder="New Password" name="newpsw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                <span class="error" id="newPasswordError" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label><br>
                                <input type="password" class="form-control" id="pass2" name="confirmpassword" placeholder="Confirm Password" required>
                                <span class="error" id="confirmPasswordError" style="color: red;"></span>
                            </div>
                            <input type="checkbox" onclick="showPasswords()">Show Password <br>
                            <small id="passwordHelp" class="form-text text-muted">Never share your password with anyone else.</small><br>
                            <span id="errorContainer"></span>
                            <div class="text-center">
                            <a href="admin-profile.php"><button type="button" class="btn btn-primary"> Return </button></a>
                            <button type="submit" class="btn btn-success">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
    </div>

    </div>

</body>

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="../script.js"></script>
    <script src="../sweet/sweetalert2.all.min.js"></script>
    <script src="../sweet/jquery-1.10.2.min.js"></script>

<script>
        $(document).ready(function() {
        $("#passwordForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Password updated successfully!',
                            icon: 'success',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response,
                            icon: 'error',
                        });
                    }
                },

                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while processing your request.',
                        icon: 'error',
                    });
                }
            });
        });
    });


    function toggleNav() {
        var sidebar = document.getElementById("mySidebar");
        var mainContent = document.getElementById("main");

        if (window.innerWidth > 600) {
            // Adjust margin on web
            if (sidebar.style.width === "230px") {
                sidebar.style.width = "60px";
                mainContent.style.marginLeft = "60px";
            } else {
                sidebar.style.width = "230px";
                mainContent.style.marginLeft = "230px";
            }
        } else {
            // Toggle sidebar without adjusting margin on mobile
            if (sidebar.style.width === "230px") {
                sidebar.style.width = "60px";
            } else {
                sidebar.style.width = "230px";
            }
        }
    }

    function showPasswords() {
        var passwordInput = document.getElementById("psw");
        var newpassword = document.getElementById("newpsw");
        var confirmPasswordInput = document.getElementById("pass2");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            newpassword.type = "text";
            confirmPasswordInput.type = "text";
        } else {
            passwordInput.type = "password";
            newpassword.type = "password";
            confirmPasswordInput.type = "password";
        }
    }
</script>

<style>
        .card {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
    #imagePreview {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 100%;
        margin-bottom: 0;

    }

    #main {
        margin: 0;
    }


    @media screen and (max-width: 600px) {
        .col-lg-6 {
            flex: 0 0 auto;
            width: 80%;
        }
    }

    .col-xl-6 {
        flex: 0 0 auto;
        width: 80%;
    }
</style>

</html>