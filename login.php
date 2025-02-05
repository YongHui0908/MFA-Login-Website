<?php
session_start();
require 'login_backend.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// if (isset($_SESSION['user_id'])) {
//   // User is already logged in, redirect to dashboard
//   header("Location: face_verification1.php");
//   exit();
// }

// Retrieve errors and input values from session
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';


?>

<!DOCTYPE HTML>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- logo -->
  <!-- Favicons -->
    <link href="assets/img/education_favicon.png" rel="icon">
    <link href="assets/img/education_favicon.png" rel="apple-touch-icon">
    <title>Login | Online University Examination</title>
    <!-- <link rel="icon" href="../tabicon/icon.webp">  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

    <!-- External CSS -->
    <link href="css/login.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
  </head>


<body>
<!-- Preloader -->
<div id="preloader"></div>
<section class="Form my-4 mx-5">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-5">
        <img class="img-fluid" src="images/educate.jpg" alt="Login Cover" alt="cover">
      </div>
      <div class="col-lg-7 px-5 pt-4">
        <h2 class="font-weight-bold py-3" style="margin-top: 20px; color: #012970;">Online University Examination</h2>
        <h6 class="font-h4" style="color: #012970;">Login to Your OUE's Account</h6>
        <form method="POST" action="login.php" class="login-email" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text my-1 p-1 px-2 bg-white" style="color: #012970;">@</div>
              </div>
              <input type="text" name="username" placeholder="Username" id="username" autocomplete="off" value="<?php echo htmlspecialchars(isset($username) ? $username : ''); ?>" class="form-control my-1 p-2">
            </div>
            <p class="text-danger mx-auto" style="margin-bottom: 15px"><?php if (isset($errors['u'])) echo htmlspecialchars($errors['u']); ?></p>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" name="password" placeholder="Password" id="psw" autocomplete="off" value="<?php echo htmlspecialchars(isset($password) ? $password : ''); ?>" class="form-control p-2">
              <div class="input-group-prepend">
                <div class="input-group-text my-0 p-1 px-3 bg-white" style="color: #012970;">
                  <i class="bi bi-eye-slash" id="togglePassword"></i>
                </div>
              </div>
            </div>
            <p class="text-danger mx-auto" style="margin-bottom: -7px"><?php if (isset($errors['p'])) echo htmlspecialchars($errors['p']); ?></p>
          </div>
          <!-- Login Button -->
          <div class="form-group">
            <button type="submit" class="btn" id="btn" name="reg_user">Login</button>
          </div>
          <br>
          <p class="login-here">Already having an account? <b><a class="lognreg" href="registration.php">Register Here!</a></b></p>
        </form>
      </div>
    </div>
  </div>
</section>

<?php
  // Display SweetAlert2 Popup for Authentication Error
  if (isset($_SESSION['errors']['auth'])) {
      echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Invalid username or password.'
          });
        });
      </script>";
      unset($_SESSION['errors']['auth']);
  }

// Display SweetAlert2 Popup for Successful Login
if (isset($_SESSION['success'])) {
  echo "<script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
        icon: 'success',toast: 'true',
          icon: 'success',
          position: 'top-end',
          title: 'Welcome!',
          text: '" . htmlspecialchars($_SESSION['success']) . "',
          showConfirmButton: false,
          timer: 2000
        }).then(() => {
            // Redirect to face verification after SweetAlert
            window.location.href = 'face_verification1.php';
        });
      });
  </script>";
  unset($_SESSION['success']); // Clear the success message after showing
}

?>
<script src="js/login.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>