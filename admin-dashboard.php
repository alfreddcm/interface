 <?php
include("user-connection.php");
include('php-admininfo.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>

<body>
  <header>
    <h2> <img src="icons/logo.png" srcset="" height="50px">
      ELOCKER</h2>
  </header>

  <div id="mySidebar" class="sidebar">
    <a class="openbtn" onclick="toggleNav()"><img src="icons/menu-icon.png" alt="" height="30px" width="30px"> <b>Menu</b></a>
    <a href="admin-dashboard.php" style="background-color: white; "><img src="icons/dashboard-icon.png" height="30px" width="30px" style="filter:invert(100);"><b style="color:black;"> Dashboard</b></a>
    <a href="admin-profile.php"><img src="icons/profile-icon.png" height="30px" width="30px"> Profile</a>
    <a href="admin-lockerlist.php"><img src="icons/locker.png" height="30px" width="30px"> Locker list</a>
    <a href="admin-userlist.php"><img src="icons/users.png" height="30px" width="30px"> Manage users</a>
    <a href="php-logout.php"><img src="icons/logout-icon.png" height="30px" width="30px"> Log out</a>
  </div>


  <div id="main">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="container">
          <div class="row">
            <div class="col-md-6 ">
              <div class="card p-4 m">
                <div class="row align-items-center">
                  <div class="col-sm-4"><img src="adminuploads/<?php echo $profile ?>" alt="Admin" class="rounded-circle" id="imagePreview">
                  </div>
                  <div class="col mx-2 overflow-hidden">
                    <div class="mt-4">
                      <p class="text-uppercase font-weight-bold mb-0"><?php echo $fname . " " . $mi . ". " . $lname ?></p>
                      <p class="text-secondary mb-0"> <?php echo $email ?>
                      </p>
                      <p class="text-secondary mb-0 text-uppercase"> <?php echo $pos ?>
                      </p>
                      <p class="text-muted font-size-sm"><?php
                                                          $sqldep = mysqli_query($conn, "SELECT dep_name from department where id=$department_id");
                                                          $row = mysqli_fetch_assoc($sqldep);
                                                          $sqldep = $row['dep_name'];
                                                          echo $sqldep;

                                                          ?></p>
                      <a href="admin-profile.php"><button class="btn btn-outline-primary">Edit Profile</button></a>
                    </div>
                  </div>

                </div>
              </div>
              <!--  -->
            </div>
            <div class="col-md-6 top">
              <div class="row">
                <div class="col-md-6 a">
                  <div class="card bg-default text-center">
                    <p class="card-text">
                    <h6>Total Lockers</h6><br>
                    <span class="number">
                      <?php
                      $sqllocker = mysqli_query($conn, "SELECT * FROM locker_data");
                      $lockernum = mysqli_num_rows($sqllocker);
                      echo $lockernum;
                      ?>
                      <img src="icons/lock-icon.png" alt="" height="60px" style="margin-top:-25px;"></span>
                    </p>
                  </div>
                </div>
                <div class="col-md-6 b">
                  <div class="card text-center">
                    <p class="card-text">
                    <h6>Total Users </h6><br>

                    <span class="number"><?php
                                          $sqluser = mysqli_query($conn, "SELECT * FROM user_data");
                                          $usernum = mysqli_num_rows($sqluser);
                                          echo $usernum;
                                          ?>

                      <img src="icons/users.png" alt="" style="filter:invert(100); margin-top:-10px;" height="60px"></span>
                    </p>
                  </div>

                </div>
              </div>
              <div class="row">
                <div class="col-md-6 c">
                  <div class="card text-center">
                    <p class="card-text">
                    <h6>Available lockers</h6><br>
                    <span class="number"><?php
                                          $av = mysqli_query($conn, "SELECT * FROM locker_data where user_id is null");
                                          $avv = mysqli_num_rows($av);
                                          echo $avv;
                                          ?></span>
                    </p>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card text-center">
                    <p class="card-text">
                    <h6>User with no Lockers</h6><br>
                    <span class="number"><?php
                                          $av = mysqli_query($conn, "SELECT * FROM user_data where locker_id is NULL");
                                          $avv = mysqli_num_rows($av);
                                          echo $avv;
                                          ?></span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-6  scroll">
          <div class="card text-center">
            <div class="card-body">
              <p class="card-text">

              <h5>
                <img src="icons/male-add-icon.png" alt="" height="20px">
                Request list
              </h5>
              <?php
              $emailres = mysqli_query($conn, "SELECT * FROM emails");

              if ($emailres && mysqli_num_rows($emailres) > 0) {
                echo '<table class="table table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>#</th>';
                echo '<th>Email</th>';
                echo '<th>Status</th>';
                echo '<th>Action</th>';
                echo '<th>Date Added</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $counter = 1;

                while ($row = mysqli_fetch_assoc($emailres)) {
                  echo '<tr>';
                  echo '<td>' . $counter . '</td>';
                  echo '<td>' . $row['email'] . '</td>';
                  echo '<td>' . $row['status'] . '</td>';

                  if ($row['status'] == 'pending') {
                    echo '<td><a
                    name="" id="acceptButton " class="btn btn-primary accept-button p-2" data-email="' . $row['email'] . '"role="button">Accept</a>
                    <a name="removeButton" id="removeButton " class="btn btn-danger remove-button p-2" data-email="' . $row['email'] . '" role="button">Remove</a></td>
                    </td>';
                  } else {
                    echo '
                    <td><a name="removeButton" id="removeButton" class="btn btn-danger remove-button p-2" data-email="' . $row['email'] . '" role="button">Remove</a></td>
                    </td>
                    ';
                  }

                  echo '<th>' . $row['date_added'] . '</th>';
                  echo '</tr>';
                  $counter++;
                }
                echo '</tbody>';
                echo '</table>';
              } else {
                echo '<p class="alert alert-info">No emails found.</p>';
              }
              ?>
            </div>
          </div>

        </div>
        <div class="col-md-6 scroll">
          <div class="card text-center overflow">
            <div class="card-body">
              <p class="card-text">
              <h6><img src="icons/project-icon.png" height="20px"> Activities</h6>
              <?php
              $query = "SELECT log.id, user.fname, user.mi, user.lname, log.locker_id, log.date_time
          FROM Log_history AS log
          JOIN user_data AS user ON log.locker_id = user.locker_id
          ORDER BY log.date_time DESC";

              $logs = mysqli_query($conn, $query);

              if ($logs && mysqli_num_rows($logs) > 0) {
                echo '<table class="table table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>User</th>';
                echo '<th>Locker</th>';
                echo '<th>Date and Time</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($logs)) {
                  echo '<tr>';
                  echo '<td>' . $row['id'] . '</td>';
                  echo '<td>' . $row['fname'] . ' ' . $row['mi'] . ' ' . $row['lname'] . '</td>';
                  echo '<td>' . $row['locker_id'] . '</td>';
                  echo '<td>' . date('F j, Y H:i:s', strtotime($row['date_time'])) . '</td>';
                  echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
              } else {
                echo '<p class="alert alert-info">No activities found.</p>';
              }
              ?>

              </p>
            </div>
          </div>


        </div>
      </div>
    </div>
    <!-- main /div -->
  </div>
  <script src="script.js"></script>
  <script>
    //do not touch//

    $(document).ready(function() {
      $(".accept-button").click(function() {
        var email = $(this).data('email');

        Swal.fire({
          title: 'Do you want to accept this request?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }).then((result) => {
          if (result.isConfirmed) {
            // Show loading indicator
            console.log("Showing loading indicator");
            Swal.showLoading();
            console.log("Ajax request initiated");

            $.ajax({
              url: 'php/send_email.php',
              type: 'POST',
              data: {
                email: email
              },
              beforeSend: function() {
                // This function is called before sending the request
              },
              success: function(response) {
                console.log("Success response received");
                Swal.fire({
                  title: 'Success!',
                  text: response,
                  icon: 'success'
                });
                location.reload();
              },
              error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                  title: 'Error!',
                  text: 'Failed to send email. ' + error,
                  icon: 'error'
                });
              },
              complete: function() {
                // Hide loading indicator after the request is completed (success or error)
                console.log("Hiding loading indicator");
                Swal.hideLoading();
              }
            });
          } else {
            Swal.fire('Canceled!', '', 'info');
          }
        });
      });
    });

    //do not touch//


    $(document).on('click', '.remove-button', function() {
      var emailToRemove = $(this).data('email');

      Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to remove the email: ' + emailToRemove,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: 'php/remove-email.php',
            data: {
              email: emailToRemove
            },
            success: function(response) {
              console.log(response);

              Swal.fire('Removed!', 'The email has been removed.', 'success');
              location.reload();

            },
            error: function() {
              Swal.fire('Error!', 'Failed to communicate with the server.', 'error');
            }
          });
        }
      });
    });

    // do not tou
  </script>
  <style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      display: inline;
    }

    .scroll .card {
      height: 300px;
      overflow-y: auto;
    }

    .number {
      display: inline;
      font-size: 60px;
      font-weight: bold;
      margin-top: -40px;
    }

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

    .user {
      width: fit-content;
    }

    .top .card {
      margin: 3px;
      height: 120px;
    }

    .overflow {
      height: 300px;
    }

    #imagePreview {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 100%;
      outline: 4px solid darkslateblue;
      outline-offset: 2px;
    }
  .m{
    box-sizing: border-box;
    height: 250px;
  }
  </style>
</body>

</html>