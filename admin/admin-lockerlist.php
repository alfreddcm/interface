<?php
include("../user-connection.php");
include('../php/php-admininfo.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
  header('Location: ../index.php');
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Locker List</title>
  <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="../sweet/sweetalert2.css" class="rel">
  <script src="../sweet/jquery-1.10.2.min.js"></script>
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
            <div class="dropdown-menu pt-3" aria-labelledby="triggerId">
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
    <a href="admin-lockerlist.php" style="background-color: white; "><img src="../icons/locker.png" style="filter:invert(100);"> <b style="color:black;"> Locker list</b></a>
    <a href="admin-userlist.php"><img src="../icons/users.png"> Manage users</a>
  </div>
  <div id="main">
    <!--  -->
    <?php
    $sql = "SELECT * FROM locker_data as ld RIGHT JOIN user_data as ud ON ld.id = ud.locker_id WHERE ud.locker_id IS NOT NULL order by ud.locker_id ASC";
    $result = $conn->query($sql);

    ?>

    <div class="container">
      <div class="row">
        <h3 class="mb-2">Locker List</h3>
        <?php
        // Display each row in Bootstrap cards
        while ($row = $result->fetch_assoc()) {
        ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">

                <div class="row justify-content-center align-items-center g-1">
                  <div class="col-md-4 text-center">
                    <img class="img" src="../icons/locker-icon.png" height="100px">
                    <?php

                    echo "<b class='num'>{$row['locker_id']}</b><br>"; ?>
                  </div>

                  <div class="col-md-8">
                    <p class="card-text">
                      <?php
                      $userid = $row['id'];
                      $sql = mysqli_query($conn, "SELECT * from user_data where id= $userid ");
                      $res = mysqli_fetch_assoc($sql);

                      echo $res['fname'] . ' ' . $res['mi'] . '. ' . $res['lname'];
                      $course_id = $res['course_id'];

                      $sql2 = mysqli_query($conn, "SELECT * from course where id= $course_id");
                      $res2 = mysqli_fetch_assoc($sql2);
                      echo "<br>" . $res["yrsec"] . ' ' . $res2['program'];
                      ?>
                    </p><br>
                    <p class="card-text">UID: <?php echo $row['uid']; ?></p><br>
                    <p class="card-text">Status: <?php echo $row['status']; ?></p>
                    <hr>
                    <div class="btn-group">
                      <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Option
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../php/locker-changceuser.php?id=<?php echo $row['locker_id'] ?>">Set User</a></li>
                      </ul>
                    </div>
                    <a name="" id="" class="btn btn-danger remove-button" data-uid="<?php echo $row['uid'] ?>" data-id="<?php echo $row['id'] ?>" role="button">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>

      <?php
      $sql = "SELECT ld.id, ld.uid, ld.status FROM locker_data as ld LEFT JOIN user_data as ud ON ld.id = ud.locker_id WHERE ud.id IS NULL";

      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo '<div class="row g-2">';
        echo '<h3 class="mb-2"> New Lockers </h3> ';
        while ($row = $result->fetch_assoc()) {
      ?>
          <div class="col-md-4 mb-4">
            <div class="card">

              <div class="row justify-content-center align-items-center g-2">

                <div class="col-md-4 text-center">
                  <img class="img" src="../icons/locker-icon.png" height="100px">
                  <?php echo "<b class='num2'>{$row['id']}</b><br>"; ?>
                </div>
                <div class="col-md-8">
                  <p class="card-text">UID: <?php echo $row['uid']; ?></p><br>
                  <p class="card-text">Status: <?php echo $row['status']; ?></p>
                  <hr>
                  <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Option
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="../php/locker-changceuser.php?id=<?php echo $row['id'] ?>">Set User</a></li>
                    </ul>
                  </div>
                  <a name="" id="" class="btn btn-danger remove-button" data-uid="<?php echo $row['uid'] ?>" data-id="<?php echo $row['id'] ?>" role="button">Remove</a>
                </div>
              </div>


            </div>

          </div>
      <?php
        }
      }
      ?>


    </div>
    <!--  -->
    <div class="form-group" style="margin-top: 12%; float:right; position: relative; ">
      <div class="col ">
        <a href="../php/add-locker.php" class="text-center">
          <button class="btn btn-light addb"><img src="../icons/locker.png" style="filter:invert(100);" alt=""> Add Locker</button>
        </a>
      </div>
    </div>
    <!--  -->


  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="../sweet/jquery-1.10.2.min.js"></script>
  <script>
    var loadingIndicator = // ... code to create/loading spinner element;

      $(document).on('click', '.remove-button', function() {
        event.preventDefault();
        var uid = $(this).data('uid');
        var id = $(this).data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: 'You are about to remove the locker id: ' + id,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '../php/remove-locker.php',
              type: 'POST',
              data: {
                uid: uid,
              },
              success: function(response) {
                console.log(response);
                Swal.fire('Removed!', 'The locker has been removed.', 'success');
                location.reload();
              },
              error: function() {
                Swal.fire('Error!', 'Failed to communicate with the server.', 'error');
              }
            });
          }
        });
      });
  </script>


  <style>
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

    .num {
      outline-color: 1px solid black;
      position: absolute;
      text-align: right;
      top: 40px;
      left: 50px;
      color: white;
      font-size: 70px;
      text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
    }

    .num2 {
      outline-color: 1px solid black;
      position: absolute;
      text-align: left;
      left: 40px;
      bottom: 5px;
      color: white;
      font-size: 70px;
      text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
    }

    hr {
      margin-bottom: 5px;
      margin-top: 5px;
    }

    .card p {
      color: #000;
    }

    .img {
      filter: drop-shadow(0 0 0.2rem black);
    }

    h3 {
      color: white;
      background: #253855b7;
      border-radius: 3px;
    }

    @media screen and (max-width: 600px) {

      .num{
        top: 9px;
        left: 45%;
      }
      .num2 {
        top: 0px;
        left: 45%;
      }

      .card {
        transform: scale(0.9);
      }

    }
  </style>
</body>

</html>