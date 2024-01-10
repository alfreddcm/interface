<?php
include("../php/php-admininfo.php");

$email = $_SESSION['email'];
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === 0) {
    $profile = $_FILES['profile']['name'];
    $tmp_name = $_FILES['profile']['tmp_name'];
    $targetDirectory = "../adminuploads/";
    move_uploaded_file($tmp_name, $targetDirectory . $profile);

    $sql_update = "UPDATE admin SET profile = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql_update);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $profile, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Updated Successfuly!');
            window.location = 'admin-updatephoto.php';        
            </script>
                   ";
            exit;
        } else {
            echo "<script>alert('Updated Failed!');
            window.location = 'admin-updatephoto.php';        
            </script>
                   ";
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error Retriving data!');
        window.location = 'admin-updatephoto.php';        
        </script>
               ";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Photo</title>
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../addcss.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile</h4>
                        <p class="card-text">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <img src="../adminuploads/<?php echo $profile ?>" alt="Avatar" class="img-fluid my-5" id="imagePreview" name="imagePreview">
                            </p><br>
                            <input type="file" class="text-center" name="profile" id="profile" onchange="previewImage()" accept="image/*" required> 
                            <div class="row justify-content-center align-items-center mt-3 g-2">
                                <div class="col">
                                    <a href="admin-profile.php"><button type="button" class="btn btn-primary"> Return </button></a>
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
    </div>

    </div>

</body>

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="../script.js">

</script>


<style>

   .card {
        padding: 5px;
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
        .card{
    overflow-x: scroll;
    height: 65%;
    width: 80%;
}
    }

    .col-xl-6 {
        flex: 0 0 auto;
        width: 80%;
    }
</style>

</html>