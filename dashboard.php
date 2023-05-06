<?php
require("config/db_connect.php");
include "./shared/nav-items.php";
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
        </div>
        <?php navItems("Dashboard") ?>
    </div>
    <section class="home-section">
        <!-- <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div> -->
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">Dashboard</span>

            </div>
        </nav>

        <?php include 'config/config.php' ?>;
        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Students</div>
                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_student_query = "SELECT * FROM tblstudentinfo";
              $dash_student_query_run = mysqli_query($conn, $dash_student_query);

              if ($student_total = mysqli_num_rows($dash_student_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $student_total</h4>";
              } else {
                echo  "<h4>No Data</h4>";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Instructors</div>

                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_faculty_query = "SELECT * FROM tblinstructor WHERE user_type = 'Faculty' AND is_deleted = false";
              $dash_faculty_query_run = mysqli_query($conn, $dash_faculty_query);

              if ($instructor_total = mysqli_num_rows($dash_faculty_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $instructor_total</h4>";
              } else {

                echo  "No Data";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Course</div>
                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_course_query = "SELECT * FROM tblcourse";
              $dash_course_query_run = mysqli_query($conn, $dash_course_query);

              if ($course_total = mysqli_num_rows($dash_course_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp; $course_total</h4>";
              } else {
                echo  "<h4>No Data</h4>";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <br><br><br><br><br><br>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">BSIT Students</div>

                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_faculty_query = ("SELECT * FROM tblstudentinfo WHERE cys LIKE 'BSIT%'");
              //  AS A INNER JOIN tblstudentinfo AS B ON A.fk_course_id = B.id WHERE coursecode = 'BSIT'";

              $dash_faculty_query_run = mysqli_query($conn, $dash_faculty_query);

              if ($BSIT_total = mysqli_num_rows($dash_faculty_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $BSIT_total</h4>";
              } else {

                echo  "No Data";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">BLIS Students</div>

                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_faculty_query = ("SELECT * FROM tblstudentinfo WHERE cys LIKE 'BLIS%'");
              //  AS A INNER JOIN tblstudentinfo AS B ON A.fk_course_id = B.id WHERE coursecode = 'BSIT'";

              $dash_faculty_query_run = mysqli_query($conn, $dash_faculty_query);

              if ($BSIT_total = mysqli_num_rows($dash_faculty_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $BSIT_total</h4>";
              } else {

                echo  "No Data";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">BSIS Students</div>

                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_faculty_query = ("SELECT * FROM tblstudentinfo WHERE cys LIKE 'BSIS%'");
              //  AS A INNER JOIN tblstudentinfo AS B ON A.fk_course_id = B.id WHERE coursecode = 'BSIT'";

              $dash_faculty_query_run = mysqli_query($conn, $dash_faculty_query);

              if ($BSIT_total = mysqli_num_rows($dash_faculty_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $BSIT_total</h4>";
              } else {

                echo  "No Data";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">BSCS Students</div>

                        <div class="number">
                            <!--PHP CODE HERE WHERE YOU WILL GET THE NUMBER OF FACULTY USER IN THE SYSTEM -->
                            <?php
              $dash_faculty_query = ("SELECT * FROM tblstudentinfo WHERE cys LIKE 'BSCS%'");
              //  AS A INNER JOIN tblstudentinfo AS B ON A.fk_course_id = B.id WHERE coursecode = 'BSIT'";

              $dash_faculty_query_run = mysqli_query($conn, $dash_faculty_query);

              if ($BSIT_total = mysqli_num_rows($dash_faculty_query_run)) {
                echo "<h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $BSIT_total</h4>";
              } else {

                echo  "No Data";
              }
              ?>
                        </div>
                        <div class="indicator">
                        </div>
                    </div>
                    <i class='bx bxs-user-circle circle'></i>
                </div>
                <!-- THIS IS THE CODE OF CHECKING ATTENDANCE IN DASHBAORD PART. KONTI LANG DITO MEDYO MAGPAKITA PA LANG NG INFO KONTI.
      YOU SHOULD ALSO PUT HERE A PHP CODE WHERE IN GETTING ALL THE NEED DATA AS YOU CAN SEE IN YOUR SCREEN RIGHT NOW -->
                <!-- <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Attendance | Today</div>
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Student No.</li>
              <li><a href="#">123456</a></li>
            </ul>
            <ul class="details">
              <li class="topic">Time In</li>
              <li><a href="#">1:16 pm</a></li>
            </ul>
            <ul class="details">
              <li class="topic">Log Date</li>
              <li><a href="#">Oct 25, 2022</a></li>
            </ul>
          </div>
          <div class="button">
            <a href="#">See All</a>
          </div>
        </div>
      </div> -->
            </div>
    </section>

    <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
    </script>
</body>

</html>