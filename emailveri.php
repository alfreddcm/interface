<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('user-connection.php');
if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    $email = "";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted via POST request

    if (isset($_POST['email'], $_POST['otp'])) {
        $verifyemail = $_POST['email'];
        $otp = $_POST['otp'];

        if (empty($otp)) {
            echo "Please input OTP!";
            exit;
        }

        $quer = mysqli_query($conn, "SELECT * FROM requestlist WHERE email='$verifyemail'");
        $numrow = mysqli_num_rows($quer);

        if ($numrow > 0) {
            $rows = mysqli_fetch_assoc($quer);

            // Check if the email is already verified
            if ($rows['otp'] === null) {
                echo 'Email already verified! Please wait for admin confirmation';
            } else {
                $savedotp = $rows['otp'];

                if ($savedotp == $otp) {
                    // Mark the email as verified by setting otp to null
                    mysqli_query($conn, "UPDATE requestlist SET otp=null WHERE email='$verifyemail'");
                    echo "success";
                } else {
                    echo "Incorrect OTP";
                }
            }
        } else {
            echo "Email not on the request list, please check your email!";
        }
    } else {
        echo "Invalid Email input!";
    }
    exit;
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Email Verification</title>
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="sweet/sweetalert2.css" class="rel">
    <script src="sweet/sweetalert2.all.min.js"></script>
    <script src="sweet/jquery-1.10.2.min.js"></script>
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

        <div class="wrapper">
            <div class="otp">
                <hr>
                <center>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="veri" class="form">
                        <div class="form-group">
                            <div class="title">Email Verification</div>
                            <p class="message">We have sent a verification code to your email number</p>


                            <div class="inputs">
                                <input type="email" name="email" value="<?php echo $email; ?>"><br>
                                <span>EMAIL</span><br>
                                <input id="input1" type="text" name="otp" maxlength="5" autocomplete="off">
                            </div>
                            <span>OTP CODE</span><br>
                            <button type="submit" class="action">verify me</button>

                        </div>
                        <div class="form-group">
                            <a name="" id="" class="btn button-secondary" href="index.php" role="button">Return</a>

                        </div>
                    </form>
                </center>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#veri").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                Swal.fire({
                    title: 'Please wait!..',
                    allowOutsideClick: false,
                    showConfirmButton: false,
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

                    success: function(response) {
                        Swal.close();

                        if (response === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Email successfully verified, Please wait for confirmation!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'index.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response,
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
    </script>
    <style>
        .form {
            display: flex;
            align-items: center;
            margin-top: 150px;
            flex-direction: column;
            justify-content: space-around;
            width: 400px;
            background-color: white;
            border-radius: 12px;
            padding: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: black
        }

        .message {
            color: #a3a3a3;
            font-size: 14px;
            margin-top: 4px;
            text-align: center
        }

        .inputs {
            margin-top: 10px
        }

        .inputs input {
            height: 32px;
            text-align: center;
            border: none;
            border-bottom: 1.5px solid #d2d2d2;
            margin: 0 10px;
        }

        .inputs input:focus {
            border-bottom: 1.5px solid royalblue;
            outline: none;
        }

        .action {
            margin-top: 24px;
            padding: 12px 16px;
            border-radius: 8px;
            border: none;
            background-color: royalblue;
            color: white;
            cursor: pointer;
            align-self: end;
        }

        input[type='email'] {
            width: 250px;
        }
    </style>

</body>


</html>