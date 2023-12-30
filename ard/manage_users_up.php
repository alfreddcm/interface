<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="../sweet/jquery-1.10.2.min.js"></script>
  <script src="../sweet/sweetalert2.all.min.js"></script>
</head>

<body>
  <main>

    <div class="table-responsive-sm" style="max-height: 870px;">
      <form id="cardForm" action="addcard.php" method="post">

        <table class="table">
          <thead class="table-primary">
            <tr>
              <th>Action</th>
              <th>No.</th>
              <th>Card UID</th>
            </tr>
          </thead>

          <tbody>
            <?php
            require '../user-connection.php';
            if (isset($_POST['token'])) {
              $token = $_POST['token'];
            }

            $sql = "SELECT * FROM newcard ORDER BY id DESC";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
              echo '<p class="error">SQL Error</p>';
            } else {
              mysqli_stmt_execute($result);
              $resultl = mysqli_stmt_get_result($result);
              if (mysqli_num_rows($resultl) > 0) {
                $count = 1;
                while ($row = mysqli_fetch_assoc($resultl)) {
            ?>
                  <tr>
                    <td>
                      <input type="hidden" id="token" name="token" value="<?php echo $token ?>">
                      <input type="radio" id="selected_card" name="selected_card" value="<?php echo $row['uid']; ?>">
                    </td>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['uid'] . " " . $token; ?>
                      <a name="" id="" class="btn btn-danger remove-button" data-iud="<?php echo $row['uid'] ?>" role="button">Remove</a>

                    </td>

                  </tr>
            <?php
                }
              }
            }
            ?>
          </tbody>
        </table>
        <a href="../admin/admin-lockerlist.php"><button type="button" class="btn btn-secondary"> Return </button></a>
        <button type="submit" class="btn btn-success" onsubmit="submitForm()">Submit</button>

      </form>
    </div>

    <script>
      $(document).on('click', '.remove-button', function() {
        var uid = $(this).data('uid');
        Swal.fire({
          title: 'Are you sure?',
          text: 'You are about to remove the card with uid: ' + uid,
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

      function submitForm() {
        var formData = new FormData(document.getElementById('cardForm'));
        $.ajax({
          type: 'POST',
          url: 'addcard.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Form Submitted!',
              text: 'Your form has been successfully submitted.',
            });
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'An error occurred while submitting the form.',
            });
          }
        });
      }
    </script>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>