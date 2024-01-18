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
   <link rel="stylesheet" href="../css/dash.css" class="re">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

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
               <span class="text-uppercase font-weight-bold"><?php echo $fname . " " . $mi . ". " . $lname ?></span><br>
               <span class="text-secondary"> <?php echo $email ?></span>
               <ul class="list-unstyled mt-2 mb-2">
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


   <!--  -->
   <div id="main" style="height: 100vh; justify-content:start; align-items:start;">
     <div class="container-fluid pt-2">
       <div class="row justify-content-center align-items-center g-2 mb-3">
         <h3 class="mb-2" style="color: white; background: #253855b7; border-radius: 3px;">Dashboard</h3>

         <div class="col">
           <a href="admin-lockerlist.php" style="text-decoration: none;">
             <div class="card">
               <div class="card-content">
                 <div class="card-body">
                   <div class="media d-flex">
                     <div class="media-body text-left">
                       <h3 class="success"><?php
                                            $sqllocker = mysqli_query($conn, "SELECT * FROM locker_data");
                                            $lockernum = mysqli_num_rows($sqllocker);
                                            echo $lockernum;
                                            ?></h3>
                       <span>Total Lockers </span>
                     </div>
                     <div class="align-self-center">
                       <i class="fa-solid fa-lock">
                         <img src="../icons/lckes.png" alt="" height="60px">
                       </i>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

           </a>
         </div>

         <div class="col">
           <a href="admin-userlist.php" style="text-decoration: none;">

             <div class="card">
               <div class="card-content">
                 <div class="card-body">
                   <div class="media d-flex">
                     <div class="media-body text-left">
                       <h3 class="success"><?php
                                            $sqluser = mysqli_query($conn, "SELECT * FROM user_data");
                                            $usernum = mysqli_num_rows($sqluser);
                                            echo $usernum;
                                            ?></h3>
                       <span>Total Users </span>
                     </div>
                     <div class="align-self-center">
                       <i class="icon-user success font-large-2 float-right">
                         <img src="../icons/team-icon.png" alt="" height="50px">

                       </i>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

           </a>
         </div>
         <div class="col">
           <a href="admin-lockerlist.php" style="text-decoration: none;">
             <div class="card">
               <div class="card-content">
                 <div class="card-body">
                   <div class="media d-flex">
                     <div class="media-body text-left">
                       <h3 class="success"> <?php
                                            $av = mysqli_query(
                                              $conn,
                                              "SELECT * FROM locker_data as ld LEFT JOIN user_data as ud ON ld.id = ud.locker_id WHERE ud.locker_id IS NULL"
                                            );
                                            $avv = mysqli_num_rows($av);
                                            echo $avv;
                                            ?></h3>
                       <span>Available lockers</span>
                     </div>
                     <div class="align-self-center">
                       <i class="icon-user success font-large-2 float-right">
                         <img src="../icons/locker-ico.png" alt="" height="60px">

                       </i>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </a>
         </div>
         <div class="col">
           <a href="admin-userlist.php" style="text-decoration: none;">

             <div class="card">
               <div class="card-content">
                 <div class="card-body">
                   <div class="media d-flex">
                     <div class="media-body text-left">
                       <h3 class="success"> <?php
                                            $av = mysqli_query($conn, "SELECT * FROM user_data where locker_id is NULL");
                                            $avv = mysqli_num_rows($av);
                                            echo $avv;
                                            ?></h3>
                       <span>Unassign Users</span>
                     </div>
                     <div class="align-self-center">
                       <i class="icon-user success font-large-2 float-right">
                         <img src="../icons/people.png" alt="" height="60px">

                       </i>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

         </div></a>
       </div>

       <div class="row row2 justify-content-center align-items-center g-2">
         <div class="col scroll">
          <div class="card text-start">
         
             <h6 class="card-header text-center" style="position: sticky; top: 0; display:relative; height:50px;">
               <img src="../icons/male-add-icon.png" alt="" height="20px">
               Request list
             </h6>
             <div>

              <?php
              $emailres = mysqli_query($conn, "SELECT * FROM requestlist WHERE department_id = $department_id AND otp IS NULL");

              if ($emailres && mysqli_num_rows($emailres) > 0) {
                echo '<table class="table mt-0 table-striped">';
                echo '<thead class="thead-dark" style="position: sticky; top: 0;">';
                echo '<tr>';
                echo '<th>#</th>';
                echo '<th>Name</th>';
                echo '<th>Date Added</th>';
                echo '<th> </th>';

                echo '</tr>';
                echo '</thead>';
                echo '<tbody class="class2">';

                $counter = 1;

                while ($row = mysqli_fetch_assoc($emailres)) {
                  echo '<tr>';
                  echo '<td>' . $counter . '</td>';
                  echo '<td>
                              <div class="dropdown dropup">
                                <label class="dropdown-toggle" type="button" id="triggerId' . $row['id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $row['fname'] . " " . $row['mi'] . ". " . $row['lname'] . '</label>
                                <div class="dropdown-menu p-1" aria-labelledby="triggerId' . $row['id'] . '" style=" width:fit-content ; font-size:13px;">
                                  <label for="">ID No: </label>
                                  <label for="">' . $row['idno'] . '</label><br>
                                  <label for="">Email: ' . $row['email'] . '</label><br>
                                  <label for="">';

                          $courseid = $row['course_id'];
                          $sqlcourse = mysqli_query($conn, "SELECT program FROM course WHERE id = $courseid ");
                          $course = mysqli_fetch_assoc($sqlcourse);
                          echo $course['program']   .

                            '</label><br>
                                </div>
                              </div>
                        </td>';
                  echo '<td>' . date('M j, Y h:i A', strtotime($row['date_added'])) . '</td>';

                  echo '  <td><a
                            name="" id="acceptButton " class="btn btn-primary accept-button p-1 text-white" data-email="' . $row['email'] . '"role="button">Accept</a>
                            <a name="removeButton" id="removeButton " class="btn btn-danger remove-button p-1 text-white" data-email="' . $row['email'] . '" role="button">Remove</a>
                            </td>
                         ';
                  echo '</tr>';
                  $counter++;
                }
                echo '</tbody>';
                echo '</table>';
              } else {
                echo '<p class="alert alert-info"> No emails found.</p>';
              }
              ?>
              </div>
            </div>
          </div>
          <!--  -->

  
<!--  -->
         <div class="col scroll">
           <div class="card text-start  border-primary">
             <div class="card-header act">
               <h6 class="text-center" style="height: 15px;">
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

   </div>

   <!-- main /div -->
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
             Swal.fire({
           title: 'Please wait..',
           allowOutsideClick: false,
           showConfirmButton: false,
           onBeforeOpen: () => {
             Swal.showLoading();
           }
         });
             $.ajax({
               url: '../php/send_email.php',
               type: 'POST',
               data: {
                 email: email
               },
               beforeSend: function() {},
               success: function(response) {
                 Swal.close();

                 Swal.fire({
                   title: 'Success!',
                   text: response,
                   icon: 'success'
                 }).then((result) => {
                   if (result.isConfirmed) {
                     // Reload the page
                     location.reload();
                   }
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
          Swal.fire({
           title: 'Please wait..',
           allowOutsideClick: false,
           showConfirmButton: false,
           onBeforeOpen: () => {
             Swal.showLoading();
           }
         });
           $.ajax({
             type: 'POST',
             url: '../php/remove-email.php',
             data: {
               email: emailToRemove
             },
             success: function(response) {
               console.log(response);
               Swal.close();
               Swal.fire({
                  title: 'Removed!',
                  text: 'The email has been removed.',
                  icon: 'success',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      location.reload();
                  }
              });

             },
             error: function() {
              Swal.fire({
              title: 'Removed!',
              text: 'The email has been removed.',
              icon: 'success',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
          }).then((result) => {
              if (result.isConfirmed) {
                  location.reload();
              }
          });         
              }
           });
         }
       });
     });

     function confirmLogout() {
       Swal.fire({
         title: 'Are you sure?',
         text: 'You will be logged out!',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, log me out!'
       }).then((result) => {
         if (result.isConfirmed) {
           // Redirect to the logout script or perform your logout logic here
           window.location.href = '../php/php-logout.php';
         }
       });
     }

     // do not touch
   </script>


 </body>

 </html>