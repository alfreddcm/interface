 <?php
  include("../user-connection.php");
  include('../php/php-admininfo.php');
  ?>
 <!DOCTYPE html>
 <html>

 <head>
   <title>Dashboard</title>
   <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">

   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="../style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
     <a href="admin-dashboard.php" style="background-color: white; "><img src="../icons/dashboard-icon.png" style="filter:invert(100);"><b style="color:black;"> Dashboard</b></a>
     <a href="admin-lockerlist.php"><img src="../icons/locker.png"> Locker list</a>
     <a href="admin-userlist.php"><img src="../icons/users.png"> Manage users</a>
   </div>


   <div id="main">
     <div class="container-fluid">
       <div class="row justify-content-center align-items-center g-2 mb-3">
         <div class="col">
           <a href="admin-lockerlist.php" style="text-decoration: none;">

             <div class="card text-center smcard">
               <p class="card-text">
               <h6>Total Lockers</h6>
               <span class="number">
                 <?php
                  $sqllocker = mysqli_query($conn, "SELECT * FROM locker_data");
                  $lockernum = mysqli_num_rows($sqllocker);
                  echo $lockernum;
                  ?>
                 <img src="../icons/lock-icon.png" alt="" height="60px" style="margin-top:-25px;"></span>
               </p>
             </div>
           </a>
         </div>
         <div class="col">
           <a href="admin-userlist.php" style="text-decoration: none;">
             <div class="card text-center smcard">
               <p class="card-text">
               <h6>Total Users </h6>

               <span class="number">
                 <?php
                  $sqluser = mysqli_query($conn, "SELECT * FROM user_data");
                  $usernum = mysqli_num_rows($sqluser);
                  echo $usernum;
                  ?>

                 <img src="../icons/users.png" alt="" style="filter:invert(100); margin-top:-10px;" height="60px"></span>
               </p>
             </div>
           </a>
         </div>
         <div class="col">
           <a href="admin-lockerlist.php" style="text-decoration: none;">

             <div class="card text-center smcard">
               <p class="card-text">
               <h6>Available lockers</h6>
               <span class="number">
                 <?php
                  $av = mysqli_query(
                    $conn,
                    "SELECT * FROM locker_data as ld LEFT JOIN user_data as ud ON ld.id = ud.locker_id WHERE ud.locker_id IS NULL"
                  );
                  $avv = mysqli_num_rows($av);
                  echo $avv;
                  ?></span>
               </p>

             </div>
           </a>
         </div>
         <div class="col">
         <a href="admin-userlist.php" style="text-decoration: none;">

           <div class="card text-center smcard">
             <p class="card-text">
             <h6>Unassign Users</h6>
             <span class="number">
               <?php
                $av = mysqli_query($conn, "SELECT * FROM user_data where locker_id is NULL");
                $avv = mysqli_num_rows($av);
                echo $avv;
                ?></span>
             </p>
           </div>
         </div></a>
       </div>

       <div class="row row2 justify-content-center align-items-center g-2">
         <div class="col scroll ">
           <div class="card  mb-2 text-start">
             <h6 class="card-header text-center">
               <img src="../icons/male-add-icon.png" alt="" height="20px">
               Request list
             </h6>
             <?php
              $emailres = mysqli_query($conn, "SELECT * FROM requestlist where department_id = $department_id");

              if ($emailres && mysqli_num_rows($emailres) > 0) {
                echo '<table class="table table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th>#</th>';
                echo '<th>Name</th>';
                echo '<th>Date Added</th>';
                echo '<th>Action</th>';

                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $counter = 1;

                while ($row = mysqli_fetch_assoc($emailres)) {
                  echo '<tr>';
                  echo '<td>' . $counter . '</td>';
                  echo '<td>' . $row['fname'] . " " . $row['mi'] . ". " . $row['lname'] . '</td>';

                  echo '<td>' . date('F j, Y h:i A', strtotime($row['date_added'])) . '</td>';

                  echo '<td><a
                    name="" id="acceptButton " class="btn btn-primary accept-button p-1" data-email="' . $row['email'] . '"role="button">Accept</a>
                    <a name="removeButton" id="removeButton " class="btn btn-danger remove-button p-1" data-email="' . $row['email'] . '" role="button">Remove</a></td>
                    </td>';
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

         <div class="col scroll">
           <div class="card text-start">
             <div class="card-header">
               <h6 class="text-center">
                 <img src="../icons/project-icon.png" alt="" height="20px">
                 Activities
               </h6>
               <input type="date" class="form-control" id="datepicker">
             </div>
             <div style="overflow-y: hidden;">
               <div id="data"></div>
             </div>
           </div>
         </div>

       </div>
     </div>


     <!-- main /div -->
   </div>
   <script src="../script.js"></script>
   <script>
     $(document).ready(function() {
       function updateManageUsers(filterDate) {
         $.ajax({
           url: "../php/updatelogs.php",
           method: 'POST',
           data: {
             filterDate: filterDate
           }, // Pass the filterDate parameter
         }).done(function(data) {
           $('#data').html(data);
         });
       }

       updateManageUsers(); // Initial load without filtering

       $('#datepicker').on('change', function() {
         var selectedDate = $(this).val();
         updateManageUsers(selectedDate); // Update logs with the selected date
       });

       setInterval(function() {
         updateManageUsers($('#datepicker').val()); // Update logs with the current selected date
       }, 6000);
     });




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
               url: '../php/send_email.php',
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
         text: 'You are about to remove the user with email: ' + emailToRemove,
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, remove it!'
       }).then((result) => {
         if (result.isConfirmed) {
           $.ajax({
             type: 'POST',
             url: '../php/remove-email.php',
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

     // do not touch
   </script>
   <style>
     #datepicker {
      margin: 1px;
       top: 0;
       right: 0;
       margin-right: 10px;
       position: absolute;
       width: fit-content;
     }
     .scroll .card {
       height: 250px;
     }

     .scroll p {
       overflow-y: auto;

     }

     .number {
       display: inline;
       font-size: 40px;
       font-weight: bold;

     }

     .container-lg {
       background-color: rgba(0, 0, 0, 0.223);
       width: auto;
       height: fit-content;
       padding: 10px;
       padding-bottom: 30px;
     }

     .modal-body {
       color: black;
     }

     #con {
       display: block;
       padding: 0px;
     }

     .user {
       width: fit-content;
     }

     .overflow {
       height: 300px;
     }

     #imagePreview {
       margin: 15px;
       align-self: center;
       justify-self: center;
       width: 150px;
       height: 150px;
       object-fit: cover;
       border-radius: 50%;
       outline: 4px solid darkslateblue;
       outline-offset: 2px;
     }


     .info {
       height: 100%;
     }

     .info p {
       font-size: .9rem;

     }



     @media screen and (max-width: 600px) {
       .col {
         width: 100%;
         justify-content: center;
         align-items: center;
         margin-bottom: 10px;
       }

       .smcard {
         display: block;
         width: 190px;
         height: 100px;
         margin-bottom: 2px;
       }

       .row2 .card {
         width: 400px;
       }

       table {
         font-size: small;
       }

       .btn {

         transform: scale(.8);
       }
     }
   </style>
 </body>

 </html>