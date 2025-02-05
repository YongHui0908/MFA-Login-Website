<?php
session_start();
require 'admin_exam_attendance_backend.php';
require 'pdf_export.php';
require 'csv_export.php';

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

  <title>Examination Attendance | Online University Examination</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/education_favicon.png" rel="icon">
  <link href="assets/img/education_favicon.png" rel="apple-touch-icon">

  <!-- Sweetalert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Update Remark -->
  <script src="js/editable_remark.js"></script>

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
<style>
.table {
    margin-bottom: 50px; /* Adjust this value as needed */
}

#trafficChart {
    margin-top: 20px; /* Push chart below other elements */
}
</style>

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
        <a class="nav-link collapsed" href="admin_dashboard.php">
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
        <a class="nav-link" href="admin_exam_attendance.php">
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
      <h1>Examination Attendance</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
          <!-- <li class="breadcrumb-item">Tables</li> -->
          <li class="breadcrumb-item active">User Examination Attendance</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="card-title text-center">User Examination Attendance Record</h5>
              <div>
                <button id="exportPDF" class="btn btn-danger">Export as PDF</button>
                <button id="exportCSV" class="btn btn-success">Export as CSV</button>
              </div>
            </div>
            
            <!-- Form to filter by Course and Exam Module -->
            <form method="GET" action="admin_exam_attendance.php">
              <div class="row d-flex justify-content-between align-items-center"  style="margin-top: 15px">
                <div class="col-md-4">
                  <label for="course">Select Course:</label>
                  <select name="course" id="course" class="form-control">
                    <option value="">All Courses</option>
                    <!-- Populate options dynamically from the database -->
                    <?php
                      // Fetch all courses
                      $stmt = $pdo->query("SELECT DISTINCT course FROM user_details");
                      while ($course = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Skip "Not Selected"
                        if (strcasecmp($course['course'], 'Not Selected') === 0) {
                          continue;
                        }
                          echo "<option value='{$course['course']}'" . (isset($_GET['course']) && $_GET['course'] == $course['course'] ? ' selected' : '') . ">{$course['course']}</option>";
                      }
                    ?>
                  </select>
                </div>
                    
                <div class="col-md-4">
                  <label for="exam_module">Select Exam Module:</label>
                  <select name="exam_module" id="exam_module" class="form-control">
                    <option value="">All Exam Modules</option>
                    <!-- Populate options dynamically from the database -->
                    <?php
                      // Fetch all exam modules
                      $stmt = $pdo->query("SELECT DISTINCT exam_name FROM user_exam_activity");
                      while ($exam_module = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo "<option value='{$exam_module['exam_name']}'" . (isset($_GET['exam_module']) && $_GET['exam_module'] == $exam_module['exam_name'] ? ' selected' : '') . ">{$exam_module['exam_name']}</option>";
                      }
                    ?>
                  </select>
                </div>
                    
                <div class="col-md-3" style="margin-top: 23px;">
                  <button type="submit" class="btn btn-primary">Filter</button>
                </div>
              </div>
            </form>

              <!-- <h5 class="card-title text-center">User Examination Attendance Record</h5> -->
              <!-- <p>Below is a detailed list of exam candidates, including their username, course of study, exam module, start and completed time.</p> -->

              <!-- Table with stripped rows -->
              <table class="table my-4">
                <thead>
                  <tr>
                    <th>
                      <b>Username</b>
                    </th>
                    <th>Course</th>
                    <th>Exam Module</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Remark</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($userExams as $Exam): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($Exam['username']); ?></td>
                        <td><?php echo htmlspecialchars($Exam['course']); ?></td>
                        <td><?php echo htmlspecialchars($Exam['exam_name']); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($Exam['start_time'])); ?></td>
                        <td><?php echo date('Y/m/d H:i', strtotime($Exam['end_time'])); ?></td>
                        <td><?php echo htmlspecialchars($Exam['remark']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
    <script>
      document.getElementById('exportPDF').addEventListener('click', () => {
        window.location.href = 'admin_exam_attendance.php?export=pdf&course=<?php echo isset($_GET['course']) ? $_GET['course'] : ''; ?>&exam_module=<?php echo isset($_GET['exam_module']) ? $_GET['exam_module'] : ''; ?>';
    });

    document.getElementById('exportCSV').addEventListener('click', () => {
        window.location.href = 'admin_exam_attendance.php?export=csv&course=<?php echo isset($_GET['course']) ? $_GET['course'] : ''; ?>&exam_module=<?php echo isset($_GET['exam_module']) ? $_GET['exam_module'] : ''; ?>';
    });

    </script>


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
</html>
