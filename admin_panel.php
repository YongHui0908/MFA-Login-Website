<?php
session_start();
require 'exam_module_overview.php';

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

  <title>Admin Panel | Online University Examination</title>
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
        <a class="nav-link collapsed" href="admin_dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link " href="admin_panel.php">
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
      <h1>Admin Panel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
          <!-- <li class="breadcrumb-item">Users</li> -->
          <li class="breadcrumb-item active">Admin Panel</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                      <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                      </li>
                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Add Exam Modules</button>
                      </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Exam Modules</h5>
                            <p>Below is a detailed list of current exam paper, including their associated course, and link. You are allow to delete unwanted ones.</p>

                            <!-- Table with stripped rows -->
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>
                                    <b>Exam Name</b>
                                    </th>
                                    <th>Associated Courses</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($examOverview as $overview): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($overview['exam_name']); ?></td>
                                        <td><?php echo htmlspecialchars($overview['associated_courses']); ?></td>
                                        <td>
                                          <a href="<?php echo htmlspecialchars($overview['exam_link']); ?>" target="_blank" title="<?php echo htmlspecialchars($overview['exam_link']); ?>">
                                                <?php echo htmlspecialchars(strlen($overview['exam_link']) > 30 ? substr($overview['exam_link'], 0, 30) . '...' : $overview['exam_link']); ?>
                                          </a>
                                        </td>
                                        <td>
                                          <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $overview['exam_id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>


                        <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Add New Exam Form -->
                            <form method="POST" action="create_exam.php">
                                <div class="row mb-3">
                                    <label for="examName" class="col-md-4 col-lg-3 col-form-label">Exam Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="examName" type="text" class="form-control" id="examName" required minlength="3" maxlength="100" pattern="^[a-zA-Z0-9\s]+$" title="Only letters, numbers, and spaces are allowed.">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="associatedCourse" class="col-md-4 col-lg-3 col-form-label">Associated Course</label>
                                    <div class="col-md-8 col-lg-9">
                                        <select id="associatedCourse" name="associatedCourses[]" class="form-control" multiple required>
                                            <option disabled selected value="">Select Course</option>
                                            <option value="Cyber Security">Cyber Security</option>
                                            <option value="Software Engineering">Software Engineering</option>
                                            <option value="Computer Science">Computer Science</option>
                                            <option value="Artificial Intelligence">Artificial Intelligence</option>
                                            <option value="E-Business">E-Business</option>
                                        </select>
                                        <small class="form-text text-muted">Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="examLink" class="col-md-4 col-lg-3 col-form-label">Link</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="examLink" type="url" class="form-control" id="examLink" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form><!-- Add New Exam Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->
                    </div>
                </diiv>

            </div>
          </div>

        </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const examId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send a request to delete the exam
                    fetch('delete_exam.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ exam_id: examId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'The exam has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page or remove the row
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the exam.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
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
<script src="js/create_exam.js"></script>
<script src="js/logout.js"></script>
</html>
