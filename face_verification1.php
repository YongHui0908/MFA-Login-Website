<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
  }

?>
<!DOCTYPE html
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Verification</title>

    <!-- Favicons -->
    <link href="assets/img/education_favicon.png" rel="icon">
    <link href="assets/img/education_favicon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

    <style>
        #videoContainer {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        #video {
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        #captureButton {
            margin-top: 15px;
        }
    </style>
</head>
<body style="background-color: #f6f9ff;">
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item right">
                <a class="nav-link" href="logout.php">Sign Out</a>
            </li>
        </ul>
    </div>
</nav>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="#" class="logo d-flex align-items-center">
    <img src="assets/img/education_favicon.png" alt="">
    <span class="d-none d-lg-block">OUE Dashboard</span>
  </a>
  <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
</div><!-- End Logo -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item dropdown pe-3">
        <a class="dropdown-item d-flex align-items-center" href="#" id="logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
        </a>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->

    <div class="container mt-4">
        <h1 class="text-center">Face Verification</h1>
        <div id="videoContainer">
            <video id="video" width="640" height="480" autoplay></video>
        </div>
        <div class="text-center">
            <button class="btn btn-primary" id="captureButton">Verify</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const video = document.getElementById('video');
        const captureButton = document.getElementById('captureButton');

        // Access the camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                Swal.fire('Error', 'Cannot access the camera. Please allow camera permissions.', 'error');
            });

        // Capture image and send for verification
        captureButton.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const liveImage = canvas.toDataURL('image/jpeg');

            // Show a loading spinner
            Swal.fire({
                title: 'Verifying face...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send image to backend for verification
            fetch('face_verification_backend1.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `liveImage=${encodeURIComponent(liveImage)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Face verified successfully!',
                            text: 'Redirecting...',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
                });
        });
    </script>
    <script src="js/logout.js"></script>
</body>
</html>

