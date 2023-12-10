<?php
include('php/php-add-admin.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="addcss.css" class="rel">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Register</title>
</head>
<style>
  html,
  body {
    display: flex;
    justify-content: center;
    height: 100%;
  }

  body,
  div,
  h1,
  form,
  input,
  p {
    padding: 0;
    margin: 0;
    outline: none;
    font-family: Roboto, Arial, sans-serif;
    font-size: 16px;
    color: #666;
  }

  h1 {
    padding: 10px 0;
    font-size: 32px;
    font-weight: 300;
    text-align: center;
  }

  p {
    font-size: 12px;
  }



  .main-block {
    width: 85%;
    height: fit-content;
    padding: 10px;
    margin: 20px;
    border-radius: 5px;
    border: solid 1px #ccc;
    box-shadow: 1px 2px 5px rgba(0, 0, 0, .31);
    background: #ebebeb;
  }

  form {
    margin: 0 30px;
  }

  .account-type,
  .gender {
    margin: 15px 0;
  }


  label#icon {
    margin: 0;
    border-radius: 5px 0 0 5px;
  }

  label.radio {
    position: relative;
    display: inline-block;
    padding-top: 4px;
    margin-right: 20px;
    text-indent: 30px;
    overflow: visible;
    cursor: pointer;
  }

  label.radio:before {
    content: "";
    position: absolute;
    top: 2px;
    left: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #1c87c9;
  }

  label.radio:after {
    content: "";
    position: absolute;
    width: 9px;
    height: 4px;
    top: 8px;
    left: 4px;
    border: 3px solid #fff;
    border-top: none;
    border-right: none;
    transform: rotate(-45deg);
    opacity: 0;
  }

  input[type=radio]:checked+label:after {
    opacity: 1;
  }

  input[type=text],
  input[type=password],
  input[type=email] {

    width: 100%;
    height: 36px;
    margin: 13px 0 0 -5px;
    padding-left: 10px;
    border-radius: 0 5px 5px 0;
    border: solid 1px #cbc9c9;
    box-shadow: 1px 2px 5px rgba(0, 0, 0, .09);
    background: #fff;
  }

  input[type=password] {
    margin-bottom: 1px;
  }

  #icon {
    display: inline-block;
    padding: 9.3px 15px;
    box-shadow: 1px 2px 5px rgba(0, 0, 0, .09);
    background: #1c87c9;
    color: #fff;
    text-align: center;
  }

  .btn-block {
    margin-top: 10px;
    text-align: center;
  }

  button {
    width: 100%;
    padding: 10px 0;
    margin: 5px auto;
    border-radius: 5px;
    border: none;
    background: #1c87c9;
    font-size: 14px;
    font-weight: 600;
    color: #fff;
  }

  button:hover {
    background: #26a9e0;
  }

  #message {
    position: absolute;
    margin-top: 50px;
    display: none;
    padding-left: 20px;
    width: 20%;
  }
</style>
<div class="main-block">
  <h1>Registration</h1>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
    <hr>
    <center>
      <div class="account-type">
        <input type="radio" value="student" id="position" name="position" checked>
        <label for="radioOne" >Student</label>
        <input type="radio" value="instructor" id="position" name="position">
        <label for="radioTwo">Instructor</label>
      </div>
    </center>
    <hr>
    <div class="row justify-content-center g-2">
      <div class="col">
        <div class="form-group">
          <center>
            <img src="icons/blank-profile.png" id="imagePreview" alt="Preview" class="mt-2" id="imagePreview">
          </center>
          <br>
          <label>Profile (Upload JPG)</label><br>
          <input type="file" class="form-control-file" id="profile" name="profile" onchange="previewImage()" accept="image/*" required>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>

        <div class="form-group">
          <div id="message">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Password must contain:</h4>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item invalid" id="letter"> A <b>lowercase</b> letter</li>
                <li class="list-group-item invalid" id="capital">A <b>capital (uppercase)</b> letter</li>
                <li class="list-group-item invalid" id="number">A <b>number</b></li>
                <li class="list-group-item invalid" id="length">Minimum <b>8 characters</b></li>
              </ul>
            </div>
          </div>
          <input type="password" class="form-control" id="psw" placeholder="Password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" oninput="validateConfirmPassword()" required>
        </div>
        <div class="form-group">
          <span class="error" id="confirmPasswordError" style="color: red;"></span>
          <input type="password" class="form-control" id="pass2" placeholder="Confirm Password" oninput="validateConfirmPassword()" required>
        </div>
        <input type="checkbox" onclick="showPassword()">Show Password <br>
        <small id="passwordHelp" class="form-text text-muted">Never share your password with anyone else.</small>
      </div>
    </div>


    <div class="col2">
      <div class="row justify-content-center align-items-center g-2">
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
      <center>
        <div class="gender">
          <input type="radio" value="m" id="male" name="sex" checked>
          <label for="male" >Male</label>
          <input type="radio" value="f" id="female" name="sex">
          <label for="female" >Female</label>
        </div>
      </center>
      <div class="form-group">
        <label>Department</label>
        <?php
        $sql = "SELECT id, dep_name FROM department";
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
    <hr>    
    <button type="submit" class="btn btn-primary ">Submit</button>
    
    <a href="admin-profile.php"><button type="button" class="btn btn-secondary ">Return</button></a>
  </form>
</div>
</div>
</div>
</body>
<script src="scripts/regform.js"></script>

</html>