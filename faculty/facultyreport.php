<?php
require("../config/db_connect.php");
include "../shared_faculty/nav-items.php";
session_start();
$_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Student Profile</title>
  <link rel="stylesheet" href="../css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
    </div>
    <?php navItems("Report") ?>
  </div>
  <section class="home-section">
    <div class="header">
      <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h1>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search"></i>
      </div>
    </nav>

    <div class="home-content">
    <section class="attendance">
        <div class="attendance-list">
          <table class="table">
            <thead>
              <tr>
              <th>#</th>
              <th>Student ID Number</th>
              <th>Name</th>
              <th>Subject</th>
              <th>Time In</th>
              <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <!--PHP CODE HERE -->
              <?php
              $numid=$_SESSION["user_id"];

              $sql = "SELECT A.id, D.coursecode, E.year_code, F.section_code, C.subject_code, A.time, A.duration,
              C.id AS subject_id, C.subject_description
              FROM Tbl_faculty_add_subject AS A 
              INNER JOIN Tblinstructor AS B ON A.Fk_instructor_id = B.Id 
              INNER JOIN Tblsubject AS C ON A.Fk_subject_id = C.Id 
              INNER JOIN Tblcourse AS D ON A.Fk_course_id = D.Id 
              INNER JOIN Tblyear AS E ON A.Fk_year = E.Id 
              INNER JOIN Tblsection AS F ON A.Fk_section = F.Id 
              WHERE A.fk_instructor_id = $numid";

                $res = $conn->prepare($sql);
                $res->execute();

                $i = 1;
                if ($res->rowCount() > 0) {
                    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                <td>" . $i . "</td>
                <td>" . $row['coursecode'] . " " . $row['year_code'] . " - " . $row['section_code'] . "</td>
                <td>" . $row['subject_code'] . " " . $row['subject_description'] . "</td>
                <td>" . $row['time'] . "</td>
                <td>" . $row['duration'] . "</td>
                <td><a href = 'viewstudent.php?id=" . $row['subject_id'] . "'>View Student</a> </td>
                ";
                ?>
                <?php

                $i++;
            }
        } else {
            echo "<tr> <td colspan = '9'> NO RECORDS FOUND</td> </tr>";
        }

        ?>


            </tbody>
          </table>
    </div>



    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
</body>

</html>