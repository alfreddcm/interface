<?php
require '../user-connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <main>
    <div style="height: 200px; overflow: auto; ">
      <table class="table table-striped" border="1px" style="border-collapse: collapse; width: 100%;">
        <thead class="thead-dark" style="position: sticky; top: 0;">
          <tr>
          <th class="text-center">Locker</th>

            <th width="15%">ID</th>
            <th width="25%">User</th>
            <th>Date & Time</th>
            <th>Access</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody style="font-size: 13px;">
          <?php
          $filterDate = isset($_POST['filterDate']) ? $_POST['filterDate'] : null;
          $query = "SELECT *
                    FROM Log_history AS log
                    JOIN user_data AS user ON log.locker_id = user.locker_id";

          if ($filterDate) {
            $query .= " WHERE DATE(log.date_time) = '$filterDate'";
          }

          $query .= " ORDER BY log.date_time DESC";

          $logs = mysqli_query($conn, $query);
          $currentDate = null;

          if ($logs && mysqli_num_rows($logs) > 0) {
            while ($row = mysqli_fetch_assoc($logs)) {
              $logDate = date('F j, Y', strtotime($row['date_time']));

              if ($currentDate !== $logDate) {
                echo '<tr class=" text-center" style="padding:0;"><td colspan="6">' . $logDate . '</td></tr>';
                $currentDate = $logDate;
              }

              echo '<tr>';
              echo '<td class="text-center">' . $row['locker_id'] . '</td>';

              echo '<td>' . $row['idno'] . '</td>';
              echo '<td>' . $row['fname'] . ' ' . $row['mi'] . ' ' . $row['lname'] . '</td>';
              echo '<td>' . date(' h:i A', strtotime($row['date_time'])) . '</td>';
              echo '<td>' . $row['access'] . '</td>';
              echo '<td>' . $row['action'] . '</td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="6" class="alert alert-info text-center"> No activities found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

<style>
  tbody {
    font-size: 15px;
  }
</style>

</html>
