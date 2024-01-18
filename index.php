<?php
include("php/php-login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>eLocker</title>
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/index.css" class="rel">
</head>

<body>
    <header>
        <nav class="navbar fixed-top shadow-sm">
            <div class="container px-5">
                <a class="navbar-brand fw-bold" href="#page-top"><img src="icons/logo.png" alt="" height="40px"></a>
                <div>

                </div>
            </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="row px-5 align-items-center r1">
                <div class="col-lg-6">
                    <!-- Mashead text and app badges-->
                    <div class="mb-1 text-center text-lg-start">
                        <h1 class="display-1"><b>Elocker</b></h1>
                        <p class="lead fw-normal ">
                            "Unlocking Education, Securing Futures: <br>
                            RFID - Your Key to Smart School Storage!" </p>
                    </div>
                </div>
                <div class="col-lg-5 pb-0 loginform">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="login">
                                <div class="form-container">
                                    <form class="form">
                                        <div class="title">
                                            Login
                                        </div><br>
                                        <div class="line"></div>
                                        <br>

                                        <div class="input-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" id="emmail" placeholder="">
                                        </div>
                                        <div class="input-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" placeholder="" minlength="8">
                                        </div>
                                        <input type="checkbox" class="mt-4" onclick="showPassword()">

                                        <label class="show">Show Password</label>
                                        <hr>

                                        <button class="sign">Sign in</button>
                                    </form>
                                    <div class="social-message">
                                        <div class="line"></div>
                                        <div class="line"></div>
                                    </div>
                                    <br>
                                    <p class="signup">Don't have an account?
                                        <a rel="noopener noreferrer" href="#" class="" data-bs-toggle="modal" data-bs-target="#feedbackModal">Request Access</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-black text-center fixed-bottom">
        <div class="container px-5">
            <div class="text-white-50 small">
                <div class="mb-0">&copy; Your Website 2023. All Rights Reserved.</div>
        </div>
        </div>
    </footer>
    <!-- Feedback Modal fix pphpp -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h5>Regitration Form</h5>
                    <div class="mb-3">
                        <form action="php/php-register.php" method="post" id="reg">
                            <div class="main-block">
                                <hr>
                                <div class="row justify-content-center text-start g-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                        </div>

                                        <div class="col2">
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" style="text-transform: capitalize;" pattern="[a-zA-Z]*" title="Must contain a-z characters" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Middle Initial</label>
                                                        <input type="text" class="form-control" id="mi" name="mi" placeholder="Middle initial" style="text-transform: capitalize;" pattern="[a-zA-Z]*" title=" Must contain a-z characters" maxlength="1">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" style="text-transform: capitalize;" pattern="[a-zA-Z]*" title="Must contain a-z characters" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <hr>
                                                <center>
                                                    <div class="gender">
                                                        <input type="radio" value="m" id="male" name="sex" checked>
                                                        <label for="male">Male</label>
                                                        <input type="radio" value="f" id="female" name="sex">
                                                        <label for="female">Female</label>
                                                    </div>
                                                </center>
                                                <hr>
                                            </div>

                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col">
                                                    <div class="form-group col2">
                                                        <label>ID Number</label>
                                                        <input type="text" class="form-control" id="idno" name="idno" placeholder="Enter ID Number" pattern="\d{2}-\d{4}" maxlength="7" title="Id number must have 6 digits" oninput="addHyphenidno()" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Year and Section</label>
                                                        <input type="text" class="form-control" id="ysec" name="ysec" placeholder="eg. 2-1" pattern="\d{1}-\d{1}" maxlength="3" title="Year and section 2 digits" oninput="addHyphen()" required>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Course</label>
                                                        <?php
                                                        $sql = "SELECT id, program FROM course";
                                                        $result = $conn->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            echo '<select class="form-select" id="course" name="course" required> ';
                                                            echo '<option value="" disabled selected>Select a Course</option>';

                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<option value="' . $row["id"] . '">' . $row["program"] . '</option>';
                                                            }
                                                            echo '</select>';
                                                        } else {
                                                            echo '<p>No department found</p>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Department</label>
                                                        <?php
                                                        $sql = "SELECT id, dep_name FROM department";
                                                        $result = $conn->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            echo '<select class="form-select" id="dep" name="dep" required>';
                                                            echo '<option value="" disabled selected>Select a department</option>';
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

                                            <div class="form-group">
                                                <center>
                                                    <div class="g-recaptcha mt-2" data-sitekey="6LfQMFEpAAAAAFbPG5GwBk6M81q6Zt76atds9EVM"></div>
                                                </center>
                                            </div>
                                            <hr>
                                            <center>
                                            <a href="emailveri.php">
                                            <span> Click here to verify email!</span></a></center>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                    <button class="btn btn-info" type="button" data-bs-dismiss="modal" aria-label="Close"> Return</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="sweet/jquery-1.10.2.min.js"></script>
    <script src="sweet/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#login").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                Swal.fire({
                    title: 'Logging in...',
                    html: '<div class="spinner-grow text-muted"></div><div class="spinner-grow text-primary"></div> <div class="spinner-grow text-success"></div><div class="spinner-grow text-info"></div><div class="spinner-grow text-warning"></div><div class="spinner-grow text-danger"></div> <div class="spinner-grow text-secondary"></div><div class="spinner-grow text-dark"></div><div class="spinner-grow text-light"></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false, // Hide the default OK button
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        if (response.error) {
                            Swal.fire({
                                title: 'Error',
                                text: response.error,
                                icon: 'error',
                            });
                        } else {
                            // Redirect on success
                            window.location.href = response.redirect;
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


        $(document).ready(function() {
            $("#reg").submit(function(e) {
                e.preventDefault();

                var email = document.getElementById('email');

                // Check if reCAPTCHA is verified
                if (grecaptcha.getResponse() === "") {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please complete the reCAPTCHA verification.',
                        icon: 'error',
                    });
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.startsWith('success')) {

                            let email = response.substring(7);

                            console.log(email);
                            Swal.fire({
                                title: 'Success',
                                text: 'Success! OTP has been send to your email. ',
                                icon: 'success',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'emailveri.php?email=' + email;

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

        function showPassword() {
            var passwordInput = document.getElementById("password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        function addHyphen() {
            var input = document.getElementById('ysec');
            var value = input.value.replace(/\D/g, '');
            if (value.length >= 1) {
                value = value.slice(0, 1) + '-' + value.slice(1);
            }
            input.value = value;
        }

        function addHyphenidno() {
            var input2 = document.getElementById('idno');
            var value = input2.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '-' + value.slice(2);
            }
            input2.value = value;
        }
    </script>
</body>

</html>