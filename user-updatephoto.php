<?php
include("php/php-userinfo.php");

$email = $_SESSION['email'];
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === 0) {
    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $targetDirectory = "uploads/";
    move_uploaded_file($tmp_name, $targetDirectory . $profile);

    $sql_update = "UPDATE user_data SET user_profile = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql_update);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $profile, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "success";
            exit;
        } else {
            echo "error";
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error Retriving data!');
        window.location = 'user-updatephoto.php';        
        </script>
               ";
        exit;
    }
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Photo</title>
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="addcss.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="sweet/sweetalert2.all.min.js"></script>
    <script src="sweet/jquery-1.10.2.min.js"></script>

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
        <a href="#" onclick="confirmLogout();"><img src="icons/logout-icon.png" height="30px" width="30px"> Log out</a>
    </div>

    <div id="main">
    <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile</h4>
                        <p class="card-text">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form" enctype="multipart/form-data">
                            <img src="uploads/<?php echo $user_profile ?>" alt="Avatar" class="img-fluid my-5" id="imagePreview" name="imagePreview">
                            </p><br>

                            <label for="file" class="custum-file-upload">
                                <div class="icon">

                                    <div class="text">
                                        <span></span>
                                    </div>
                                    <input type="file" name="profile" id="profile" onchange="previewImage()" accept="image/*" required>

                            </label>
                    </div>
                </div>

                <div class="row justify-content-center align-items-center mt-3 g-2">
                    <div class="col">
                        <a href="user-profile.php"><button type="button" class="btn btn-primary"> Return </button></a>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2">
                            <button type="submit" name="" id="" class="btn btn-success">
                                Confirm
                                </form></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

<script src="js/logout.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="script.js">

</script>
<script>
    $(document).ready(function() {
        $("#form").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Photo Updated!',
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
</script>


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

    #main {
        margin: 0;
    }
    .card{
        padding: 5px;
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

    .custum-file-upload {
        height: 20px;
        width: 300px;
        display: flex;
        flex-direction: column;
        align-items: space-between;
        gap: 20px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border: 2px dashed #e8e8e8;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0px 48px 35px -48px #e8e8e8;
    }

    .custum-file-upload .icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custum-file-upload .text {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custum-file-upload .text span {
        font-weight: 400;
        color: #e8e8e8;
    }

    input::file-selector-button {
        display: none;

    }

    input::-webkit-file-upload-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
    }
</style>

</html>