<?php
session_start();
require 'registration_backend.php'; // Ensure this is the correct path to your registration_backend.php file

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Online University Examination Account</title>

    <!-- Favicons -->
    <link href="assets/img/education_favicon.png" rel="icon">
    <link href="assets/img/education_favicon.png" rel="apple-touch-icon">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/register.css" rel="stylesheet">
</head>

<body>
<div id="preloader"></div>
<section class="Form my-4 mx-5">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-5">
                <img src="images/educate.jpg" alt="Login Cover" class="img-fluid" style="height: 780px; object-fit: cover;">
            </div>
            <div class="col-lg-7 px-4 pt-3">
                <h2 class="font-weight-bold py-2" style="color: #012970;">Online University Examination</h2>
                <h6 style="color: #012970;">Create Your Account</h6>
                <form id="uploadForm" method="POST" action="registration.php" enctype="multipart/form-data">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control my-1" placeholder="Username" 
                            value="<?php echo htmlspecialchars(isset($username) ? $username : ''); ?>">
                            <small id="usrnameInline" class="form-text" style="margin-top: -6px;" aria-live="polite">*Must contain only letters, numbers, and underscores (_), with no spaces or special characters.</small>
                        <p class="text-danger p2" style="margin-bottom: -15px; margin-top: -6px;"> <?php if (isset($errors['u'])) echo htmlspecialchars($errors['u']); ?> </p>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" 
                            value="<?php echo htmlspecialchars(isset($email) ? $email : ''); ?>">
                        <p class="text-danger p2" style="margin-bottom: -15.5px; margin-top: -2px;"> <?php if (isset($errors['e'])) echo htmlspecialchars($errors['e']); ?> </p>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <input type="tel" id="phonenumber" name="phonenumber" class="form-control" placeholder="Phone Number" 
                                value="<?php echo htmlspecialchars(isset($phonenumber) ? $phonenumber : ''); ?>">
                            <p class="text-danger p2" style="margin-bottom: 0px; margin-top: -2px;"> <?php if (isset($errors['phone'])) echo htmlspecialchars($errors['phone']); ?> </p>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" id="nationalid" name="nationalid" class="form-control" placeholder="National ID" 
                                value="<?php echo htmlspecialchars(isset($nationalid)  ? $nationalid : ''); ?>" pattern="\d+">
                            <p class="text-danger p2" style="margin-bottom: 0px; margin-top: -2px;"> <?php if (isset($errors['n'])) echo htmlspecialchars($errors['n']); ?></p>
                        </div>
                        <div class="form-group col-md-4">
                            <select id="course" name="course" class="form-control" required>
                                <option disabled selected value="">Select Course</option>
                                <option value="Cyber Security">Cyber Security</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Artificial Intelligence">Artificial Intelligence</option>
                                <option value="E-Business">E-Business</option>
                            </select>
                            <!-- <input type="hidden" id="course" name="course" value="cyber_security"> -->
                            <p class="text-danger p2" style="margin-bottom: 0px; margin-top: -2px;" id="courseError"> <?php if (isset($errors['course'])) echo htmlspecialchars($errors['course']); ?></p>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: -15px;">
                        <input type="text" id="homeaddress" name="homeaddress" class="form-control" placeholder="Home Address" 
                            value="<?php echo htmlspecialchars(isset($homeaddress) ? $homeaddress : ''); ?>">
                        <p class="text-danger p2" style="margin-bottom: -15px; margin-top: -2px;"> <?php if (isset($errors['h'])) echo htmlspecialchars($errors['h']); ?> </p>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="password" id="psw" name="password" class="form-control" placeholder="Password">
                            <p class="text-danger p2" style="margin-bottom: 0px; margin-top: -2px;"> <?php if (isset($errors['p'])) echo htmlspecialchars($errors['p']); ?> </p>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" id="cpsw" name="cpassword" class="form-control" placeholder="Confirm Password">
                            <p class="text-danger p2" style="margin-bottom: 0px; margin-top: -2px;"> <?php if (isset($errors['cp'])) echo htmlspecialchars($errors['cp']); ?> </p>
                        </div>
                        <small id="passwordHelpInline" class="form-text" style="margin-top: -16px;" aria-live="polite">&nbsp; *Use at least 8 characters with a mix of uppercase and lowercase letters, numbers & symbols</small>
                    </div>
                    <!-- Webcam Section -->
                    <div class="form-group text-center">
                        <h6 style="color: #012970;">Capture Your Face:</h6>
                        <video id="camera" autoplay playsinline width="320" height="240"></video>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <p class="text-danger p2" style="margin-bottom: -3px;"><?php if (isset($errors['face'])) echo htmlspecialchars($errors['face']); ?></p>
                        <div id="previewContainer"></div>
                        <button type="button" id="capture" class="btn btn-primary mt-2">Capture</button>
                        <button type="button" id="retake" class="btn btn-warning mt-2 text-white" style="display: none;">Retake</button>
                        <input type="hidden" name="imageData" id="imageData" value="">
                    </div>

                    <div class="form-group">
                        <button type="submit" style="margin-top: -10px;" name="reg_user" class="btn btn-success" onclick="disableSubmit(this);">Register</button>
                    </div>
                </form>
                <p>Already have an account? <b><a href="login.php">Login Here</a><b></p>
            </div>
        </div>
    </div>
</section>

<script src="js/register.js"></script>
<?php
if (isset($_SESSION['duplicate'])) {
    $duplicateType = $_SESSION['duplicate'];
    unset($_SESSION['duplicate']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '" . ($duplicateType === 'username' ? 'Username already exists!' : 'Email already exists!') . "',
        });
    </script>";
} elseif (isset($_SESSION['decode_error'])) {
    unset($_SESSION['decode_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Decode and validate the image failed.',
        });
    </script>";
} elseif (isset($_SESSION['detect_face_error'])) {
    unset($_SESSION['detect_face_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Face detection failed.',
        });
    </script>";
} elseif (isset($_SESSION['check_duplicate_face_error'])) {
    unset($_SESSION['check_duplicate_face_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Duplicate face check failed.',
        });
    </script>";
} elseif (isset($_SESSION['index_face_error'])) {
    unset($_SESSION['index_face_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Face indexing failed.',
        });
    </script>";
} elseif (isset($_SESSION['encrypted_image_error'])) {
    unset($_SESSION['encrypted_image_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Image encryption failed.',
        });
    </script>";
} elseif (isset($_SESSION['database_error'])) {
    unset($_SESSION['database_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Database error occurred.',
        });
    </script>";
} elseif (isset($_SESSION['unexpected_error'])) {
    unset($_SESSION['unexpected_error']);
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'An unexpected error occurred.',
        });
    </script>";
} elseif (isset($_SESSION['registration_success'])) {
    unset($_SESSION['registration_success']);
    echo "<script>
        Swal.fire({
            toast: true,
            icon: 'success',
            position: 'top-end',
            title: 'User registered successfully',
            showConfirmButton: false,
            timer: 2000
        }).then(function() {
            window.location.href = 'login.php'; // Redirect to login
        });
    </script>";
}
?>
</body>
</html>