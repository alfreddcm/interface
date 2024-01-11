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

      <?php
    require '../user-connection.php';

    if (isset($_POST['token'])) {
        $token = $_POST['token'];
    }
    if (isset($_POST['uid'])) {
      $posteduid = $_POST['uid'];
  }

 ?>
 <center>


        <input type="hidden" id="token" name="token" value="<?php echo $token ?>">
        <input type="text" id="selected_card" class="mb-3" name="selected_card" value="<?php echo $posteduid; ?>">
 <br>

        <a href="../admin/admin-lockerlist.php"><button type="button" class="btn btn-secondary"> Return </button></a>
        <button type="submit" class="btn btn-success" onsubmit="submitForm()">Submit</button>
</center>
      </form>
    </div>

    <script>

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
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<style>
input{
  border-radius: 23px;
  font-size: 20px;
  padding: 3px;
}
</style>
</body>

</html>