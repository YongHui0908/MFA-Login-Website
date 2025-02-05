<?php
session_start();
require 'admin_dashboard_backend.php';
require 'user_report_chart.php';
require 'course_doughnut_chart.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard | Online University Examination</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/education_favicon.png" rel="icon">
  <link href="assets/img/education_favicon.png" rel="apple-touch-icon">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="admin_dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/education_favicon.png" alt="">
        <span class="d-none d-lg-block">OUE Dashboard</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/admin.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
            <img src="assets/img/admin.png" alt="Profile" class="rounded-circle" style="height: 100px; width: 100px;">
              <h6><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></h6>
              <span>OUE Administrator</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="admin_profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" id="logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="admin_dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="admin_panel.php">
          <i class="bi bi-menu-button-wide"></i>
          <span>Admin Panel</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="admin_user_account.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>User Account</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="admin_user_examination.php">
          <i class="bi bi-journal-text"></i>
          <span>User Examination</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="admin_exam_attendance.php">
          <i class="bi bi-bar-chart"></i>
          <span>Examination Attendance</span>
        </a>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="admin_profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Total User Card -->
            <div class="col-xxl-4 col-md-6">
              <a href="admin_user_account.php">
                <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">User Account <span>| Total</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?php echo htmlspecialchars(isset($totalUserAccount['total_users']) ? $totalUserAccount['total_users'] : 0); ?></h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                      </div>
                    </div>
                  </div>

                </div>
              </a>
            </div><!-- End Total User Card -->

            <!-- Total Exam Module Card -->
            <div class="col-xxl-4 col-md-6">
              <a href="admin_panel.php">
                <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Exam Module <span>| Total</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-database-fill-check"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?php echo htmlspecialchars(isset($totalExamModule['total_exams']) ? $totalExamModule['total_exams'] : 0); ?></h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div><!-- End Total Exam Module Card -->
            

            <!-- Total User Exam Card -->
            <div class="col-xxl-4 col-md-6">
              <a href="admin_user_examination.php">
                <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Complete Exam <span>| Total</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-clipboard-data"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?php echo htmlspecialchars(isset($totalExamUser['total_exam_users']) ? $totalExamUser['total_exam_users'] : 0); ?></h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                      </div>
                    </div>
                  </div>

                </div>
              </a>
            </div><!-- End Total User Exam Card -->


            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">User Registration Reports <span>/OUE Account</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>
                
                  <!-- End Line Chart -->
                </div>
              </div>
            </div><!-- End Reports -->
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Website Traffic -->
          <div class="card">

            <div class="card-body pb-0">
              <h5 class="card-title">User Courses <span>| Breakdown</span></h5>
              <div id="courseChart" style="min-height: 400px;" class="echart"></div>

          
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="js/logout.js"></script>

  </body>
</html>
