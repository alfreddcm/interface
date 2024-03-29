<?php
include('php-add-user.php');

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../addcss.css" class="rel">
  <script src="../sweet/sweetalert2.all.min.js"></script>
  <script src="../sweet/jquery-1.10.2.min.js"></script>

  <title>Register User</title>


  <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">
  <style>
    body {
      padding: 20px;
    }

    #message {
      position: absolute;
      margin-top: 70px;
      display: none;
      padding-left: 20px;
      width: 70%;
    }
  </style>
</head>

<body>
  <main>

    <div class="container-fluid center-container">
      <div class="card">
        <div class="card-body">
          <div class="title-container">
            
            <hr>
            
            <h5 class="card-title">Add User Access Info</h5>
            <hr>
          </div>

          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"  id="form" enctype="multipart/form-data">
            <div class="row">
              <!-- First Column -->
              <div class="col">
                <div class="row justify-content-center align-items-center g-2">
                  <div class="col">

                    <div class="form-group">
                      <center>
                        <img src="../icons/blank-profile.png" id="imagePreview" alt="Preview" class="mt-2">
                      </center>
                      <br>
                      <label>Profile (Upload JPG)</label><br>
                      <input type="file" class="form-control-file" id="profile" name="profile" onchange="previewImage()" accept="image/*" required>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                      <div id="message">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Password must contain:</h4>
                          </div>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item invalid" id="letter"> A <b>lowercase</b> letter</li>
                            <li class="list-group-item invalid" id="capital"> A <b>capital (uppercase)</b> letter</li>
                            <li class="list-group-item invalid" id="number"> A <b>number</b></li>
                            <li class="list-group-item invalid" id="length"> Minimum <b>8 characters</b></li>

                          </ul>
                        </div>
                      </div>

                      <label>Password</label>
                      <input type="password" class="form-control" id="psw" placeholder="Password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninput="validateConfirmPassword()" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" oninput="validateConfirmPassword()" required>
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label><br>
                      <span class="error" id="confirmPasswordError" style="color: red;"></span>
                      <input type="password" class="form-control" id="pass2" placeholder="Confirm Password" oninput="validateConfirmPassword()" required>
                    </div>
                    <input type="checkbox" onclick="showPassword()">Show Password <br>
                    <small id="passwordHelp" class="form-text text-muted">Never share your password with anyone else.</small>

                  </div>
                </div>
                <div class="form-group col2">
                  <label>ID Number</label>
                  <input type="text" class="form-control" id="idno" name="idno" placeholder="Enter ID Number" maxlength="7" oninput="addHyphenidno()" required>
                </div>
                <div class="row justify-content-center align-items-center g-2 col2">
                  <div class="col">
                    <div class="form-group">
                      <label>First Name</label>
                      <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" pattern="[a-zA-Z]*" title="Must contain a-z characters" required>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Middle Initial</label>
                      <input type="text" class="form-control" id="mi" name="mi" placeholder="Enter middle initial" pattern="[a-zA-Z]*" title=" Must contain a-z characters" maxlength="1">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" pattern="[a-zA-Z]*" title="Must contain a-z characters" required>
                    </div>
                  </div>
                </div>

                <div class="row justify-content-center align-items-center g-2 col2">
                  <div class="col">
                    <div class="form-group">
                      <label>Sex</label>
                      <select class="form-select" id="sex" name="sex" required>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Year and Section</label>
                      <input type="text" class="form-control" id="ysec" name="ysec" placeholder="eg. 2-1" maxlength="3" oninput="addHyphen()" required>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Department</label>
                      <?php
                      $sql = "SELECT * FROM department";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {

                        echo '<select class="form-select" id="dep" name="dep" required>';
                        echo '<option value="" disabled selected>Select a department</option>';
                        while ($row = $result->fetch_assoc()) {
                          echo '<option value="' . $row["id"] . '">' . $row["dep_name"] . '</option>';
                        }
                        echo '</select>';
                      } else {
                        echo '<p>No department found</p>';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label>Course</label>
                      <?php
                      $sql = "SELECT id, program FROM course";

                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        echo '<select class="form-select" id="course" name="course" required> ';
                        echo '<option value="" disabled selected> Select a Course</option>';

                        while ($row = $result->fetch_assoc()) {
                          echo '<option value="' . $row["id"] . '">' . $row["program"] . '</option>';
                        }
                        echo '</select>';
                      } else {
                        echo '<p> No department found</p>';
                      }
                      ?>
                    </div>
                  </div>
                </div>

                <b>Select Locker Number</b>
                <select name="locker_id" id="locker_id" name="locker_id" class="form-select" aria-label="Default select example" required>
                  <?php
                  $sqlLockers = "SELECT ld.id
                  FROM locker_data AS ld
                  LEFT JOIN user_data AS ud ON ld.id = ud.locker_id
                  WHERE ud.locker_id IS NULL;
                  ";
                  $resultLockers = $conn->query($sqlLockers);
                  if ($resultLockers->num_rows > 0) {
                    while ($rowLocker = $resultLockers->fetch_assoc()) {
                      echo '<option value="' . $rowLocker["id"] . '">' . $rowLocker["id"] . '</option>';
                    }
                  } else {
                    echo '<option value="" selected disabled> No available lockers</option>';
                  }
                  ?>
                </select>
                <center>
                  <?php echo $errm ?> <br>
                  <a href="../admin/admin-userlist.php">
                    <button type="button" class="btn btn-secondary ">Return</button></a>

                  <button type="submit" class="btn btn-success ">Submit</button>
                </center>
          </form>
        </div>
      </div>
    </div>
    </div>
    </div>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="../scripts/regform.js"></script>
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
                        text: 'Account added',
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

</body>

</html>