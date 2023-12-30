<?php
require '../user-connection.php'

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <main>


<div class="card mb-2 text-center  ">
             <h6 class="card-header"><img src="../icons/project-icon.png" height="20px"> Activities</h6>
             <table class="table table-striped">
               <thead class="thead-dark">
                 <tr>
                   <th>ID</th>
                   <th width="30%">User</th>
                   <th>Locker</th>
                   <th>Date and Time</th>
                 </tr>
               </thead>
             </table>
             <div class="body">
               <tbody>
                 <?php

                  $query = "SELECT log.id, user.idno, user.fname, user.mi, user.lname, log.locker_id, log.date_time
                    FROM Log_history AS log
                    JOIN user_data AS user ON log.locker_id = user.locker_id
                    ORDER BY log.date_time DESC";

                  $logs = mysqli_query($conn, $query);

                  if ($logs && mysqli_num_rows($logs) > 0) {
                    echo '<table class="table table-striped">';

                    while ($row = mysqli_fetch_assoc($logs)) {
                      echo '<tr>';
                      echo '<td>' . $row['idno'] . '</td>';
                      echo '<td>' . $row['fname'] . ' ' . $row['mi'] . ' ' . $row['lname'] . '</td>';
                      echo '<td>' . $row['locker_id'] . '</td>';
                      echo '<td>' . date('F j, Y h:i A', strtotime($row['date_time'])) . '</td>';
                      echo '</tr>';
                    }

                    echo '</table>';
                  } else {
                    echo '<p class="alert alert-info">No activities found.</p>';
                  }
                  ?>
             </div>
           </div>
           </main>
    <footer>
      <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>