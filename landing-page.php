<?php
include("php-login.php");
?>

<!doctype html>
<html lang="en">

<head>
  <title>eLocker</title>
  <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
  <header>
  </header>
  <main>
    <section class="background-radial-gradient overflow-hidden">
      <style>
        body {
          height: 100vh;
          margin: 0;
          overflow: hidden;
        }

        #myVideo {
          object-fit: cover;
          width: 100%;
          height: 100%;
          position: fixed;
          top: 0;
          left: 0;
          z-index: -1;
        }

        .container {
          height: fit-content;
          background: linear-gradient(rgba(255, 255, 255, 0), rgba(148, 87, 235, 0.8));
          color: #f1f1f1;
          padding: 20px;
          border-radius: 23px;
          border: 2px solid white;
        }

        h2 {
          font-family: Copperplate, Papyrus, fantasy;
        }

        h4 {
          font-family: 'Courier New', monospace;
        }

      main input {
          border: none;
          background-color: transparent;
        }

        .btn {

          border: none;
          width: 80%;
        }
      </style>

      <video autoplay muted loop id="myVideo">
        <source src="bg/B21.mp4" type="video/mp4">
      </video>

      <div class="container px-2 py-5 px-md-5 text-center text-lg-start my-5">
        <div class="col-lg-12 mb-1 mb-lg-0 position-relative">

          <center class="mb-3">
            <img src="icons/logo.png" srcset="" height="100px">
            <h2>ELOCKER</h2>
            <h4>SECURE YOUR THINGS</h4>
          </center>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <!-- Email input -->
            <div class="form-outline ">
              <input type="email" id="email" name="email" class="form-control" required >
              <label class="form-label" for="email" >Usernane</label>
            </div>
            <!-- Password input -->
            <div class="form-outline ">
              <input type="password" id="password" name="password" class="form-control" required>
              <label class="form-label" for="password">Password</label>
              
            </div>
            <!-- Submit button -->
            <center><button type="submit" class="btn btn-light  text-center">
              Login
            </button></center>
            <!-- Register buttons -->
          </form>
          <hr>

          <div
            class="row text-center justify-content-center align-items-center g-2"
          >
            <div class="col">
              <button type="button" class="btn btn-light  text-center" data-bs-toggle="modal" data-bs-target="#req">
              Request for access
            </button>
            </div>
            <div class="col">
              <a href="add-user.php"><button type="button" class="btn btn-light  text-center">
              Create account
            </button></a>
            </div>
          </div>
          
          <center>
            
          </center>
        </div>
      </div>
    </section>
  </main>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="req" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
    <h5>Enter email</h5>
    <div class="mb-3">
      <form action="re.php" method="post">
    <input type="email" class="form-control" name="email" id="email"  pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" placeholder="abc@mail.com" required>        
    <button type="submit" class="btn btn-primary mt-2">Save</button>

  </form>
    </div>    
    </div>
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
  </script>
</body>
<style>
  button {
  padding: 1.3em 3em;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  font-weight: 500;
  color: #000;
  background-color: #fff;
  border: none;
  border-radius: 45px;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease 0s;
  cursor: pointer;
  outline: none;
}

button:hover {
  background-color: #23c483;
  box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
  color: #fff;
  transform: translateY(-7px);
}

button:active {
  transform: translateY(-1px);
}
</style>

</html>