<?php
session_start();
require 'profile_overview.php';

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

  <title>Profile | Online University Examination</title>
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
        <a class="nav-link collapsed" href="admin_exam_attendance.php">
          <i class="bi bi-bar-chart"></i>
          <span>Examination Attendance</span>
        </a>
      </li>

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link" href="admin_profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/admin.png" alt="Profile" class="rounded-circle">
              <h2><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></h2>
              <h3>OUE Administrator</h3>

            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Username</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($profile['username']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($profile['email']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone Number</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($profile['phonenumber']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">National ID</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($profile['nationalid']); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Home Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($profile['homeaddress']); ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form  id="profileForm" method="post">
                  <input type="hidden" name="userid" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                    <div class="row mb-3">
                      <label for="username" class="col-md-4 col-lg-3 label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <?php echo htmlspecialchars($profile['username']); ?>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="email" class="col-md-4 col-lg-3 label">Email</label>
                      <div class="col-md-8 col-lg-9">
                      <?php echo htmlspecialchars($profile['email']); ?>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="phonenumber" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phonenumber" type="tel" class="form-control" id="phonenumber" value="<?php echo htmlspecialchars($profile['phonenumber']); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="nationalid" class="col-md-4 col-lg-3 label">National ID</label>
                      <div class="col-md-8 col-lg-9">
                      <?php echo htmlspecialchars($profile['nationalid']); ?>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="homeaddress" class="col-md-4 col-lg-3 col-form-label">Home Address</label>
                      <div class="col-md-8 col-lg-9">
                      <textarea name="homeaddress" class="form-control" id="homeaddress" rows="4" required><?php echo htmlspecialchars($profile['homeaddress']); ?></textarea>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form id="changePasswordForm" method="post">
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input 
                                    name="currentPassword" 
                                    type="password" 
                                    class="form-control" 
                                    id="currentPassword" 
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input 
                                    name="newPassword" 
                                    type="password" 
                                    class="form-control" 
                                    id="newPassword" 
                                    required 
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                    title="Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.">
                                    <small id="passwordHelpInline" class="form-text" style="margin-top: -15px;" aria-live="polite"></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input 
                                    name="renewPassword" 
                                    type="password" 
                                    class="form-control" 
                                    id="renewPassword" 
                                    required><small id="passwordHelp" class="form-text" style="margin-top: -15px;" aria-live="polite">*Use at least 8 characters with a mix of uppercase and lowercase letters, numbers & symbols</small>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>

                    <!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->



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
  <!-- Include Custom JavaScript -->
  <script src="js/profile_update.js"></script>
  <script src="js/change_password.js"></script>
  <script src="js/logout.js"></script>
</body>
</html>