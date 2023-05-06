<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Class Management</title>
  <link rel="stylesheet" href="css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="dashboard.php">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="student.php">
          <i class='bx bxs-user-circle'></i>
          <span class="links_name">student Profile</span>
        </a>
      </li>
      <li>
        <a href="qr.php">
          <i class='bx bx-barcode-reader'></i>
          <span class="links_name">Generate Qr Code</span>
        </a>
      </li>
      <li>
        <a href="course.php">
          <i class="bx bx-list-ul"></i>
          <span class="links_name">Course</span>
        </a>
      </li>
      <li>
        <a href="subject.php">
          <i class='bx bx-book-content'></i>
          <span class="links_name">Subject</span>
        </a>
      </li>
      <li>
        <a href="semester.php">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">Semester</span>
        </a>
      </li>
      <li>
        <a href="room.php">
          <i class='bx bxs-school'></i>
          <span class="links_name">Room</span>
        </a>
      </li>
      <li>
        <a href="roommanagement.php">
          <i class='bx bxs-school'></i>
          <span class="links_name">Room Management</span>
        </a>
      <li>
        <a href="classmanagement.php" class="active">
          <i class="bx bx-coin-stack"></i>
          <span class="links_name">Class Management</span>
        </a>
      </li>
      <li>
        <a href="instructor.php">
          <i class='bx bxs-user-rectangle'></i>
          <span class="links_name">Instructor</span>
        </a>
      <li>
        <a href="report.php">
          <i class='bx bxs-report'></i>
          <span class="links_name">Attendance Report</span>
        </a>
      </li>
      <li>
        <a href="user.php">
          <i class="bx bx-user"></i>
          <span class="links_name">User</span>
        </a>
      </li>
      <li class="log_out">
        <a href="logout.php">
          <i class="bx bx-log-out"></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="header">
      <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h1>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Class Management</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search"></i>
      </div>
    </nav>

    <div class="home-content">
    </div>
    <section class="attendance">
      <div class="attendance-list">
        <a href="#" class="btn"> <i class='bx bx-plus'></i>Assigning Student Classes</a>
        <a href="#" class="btn">Import Student</a>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>View</th>
              <th>Generate QR</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody>
            <!--PHP CODE HERE -->
            <?php
            //echo "<tr> <td colspan = '9'>Total of records is $count</td> </tr>";

            @include './classmanagementhandler/classmanagement_eventhandler.php';
            @include './config/db_connection.php';
            $_conn = new ConnectionHandler();
            $_classmanagement = new ClassManagement($_conn);
            $result = $_classmanagement->getClassManagement();
            $number_daw_sabi_ni_czarina = 1;

            array_map(function ($info) use (&$number_daw_sabi_ni_czarina) {
              echo "<tr>
          <td>" . $number_daw_sabi_ni_czarina . "</td>
          <td>" . $info['stud_id'] . "</td>
          <td>" . $info['fname'] . " " . $info['mname'] . " " . $info['lname'] . "</td>
          <td><a href = 'student_edit_record.php?id=" . $info['id'] . "'>Edit</a> | ";
            ?>

              <a href='student_delete_record.php?id=<?php echo $info['id']; ?>' onClick="return confirm('are you sure you want to delete this?');">Delete</a></td>
            <?php
              echo "</tr>";
              $number_daw_sabi_ni_czarina++;
            }, $result) ?>
            </script>
</body>

</html>