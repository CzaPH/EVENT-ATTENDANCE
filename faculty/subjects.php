<?php
require("../config/config.php");
include('../functions.php');

$active = semester(1, $conn);
$semester = semester(0, $conn);

include "../shared_faculty/nav-items.php";
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:../index.php');
    exit;
}

$faculty_id = $_SESSION['user_id'];
if(isset($_POST['semester_id'])) {
    $semester_id = $_POST['semester_id'];
} else {
    $semester_id = $active['id'];
}

$query  = $conn->prepare("SELECT *
                            FROM
                                classes
                            INNER JOIN tblinstructor 
                                ON (classes.instructor_id = tblinstructor.id)
                            INNER JOIN tblsemester 
                                ON (classes.semester_id = tblsemester.id)
                            INNER JOIN tblsubject 
                                ON (classes.subject_id = tblsubject.id)
                            INNER JOIN tblcourse 
                                ON (classes.course_id = tblcourse.id)
                            WHERE classes.instructor_id = ? AND classes.semester_id = ?
                            AND classes.is_deleted = false");
$query->bind_param('ii', $faculty_id, $semester_id);
$query->execute();

$result = $query->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Subject</title>
  <link rel="stylesheet" href="../css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <style>
    .btn{
        padding:4px !important;
        font-size:13px !important;
        width:100%;
        height:30px;
        background:#081D45 !important;
        text-transform:uppercase !important;
        font-weight:bold;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
    </div>
    <?php navItems("Subject") ?>
  </div>
  <section class="home-section">
    <!-- <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h5>
    </div> -->
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
      </div>
      <form action="" id="form" method="POST">
        <div class="search-box">
            <?=$semester?>
            <i class="bx bx-search"></i>
        </div>
      </form>
    </nav>

    <div class="home-content">
    <section class="attendance">
        <div class="attendance-list">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Course Year & Section</th>
                <th>Subjects</th>
                <th>Schedule</th>
                <th>Attendance</th>
                <th>Report</th>
                <th>View</th>
                <th>SeatPlan</th>
              </tr>
            </thead>
            <tbody>
              <!--PHP CODE HERE -->
                <?php if(mysqli_num_rows($result) > 0):?>
                    <?php foreach($result as $key => $row):?>
                        <tr>
                            <td><?=$key + 1?></td>
                            <td><?=strtoupper($row['coursecode'])?> <?=$row['yr_and_section'] ?? ''?></td>
                            <td><?=strtoupper($row['subject_code'])?> - <?=strtoupper($row['subject_description'])?></td>
                            <td class="small">
                                <ul class="small">
                                    <?php
                                        $schedule = json_decode($row['schedules']);

                                        foreach($schedule as $sched){
                                            $sch = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM schedules WHERE schedule_id = '".$sched."'"));

                                            ?>
                                            <li style="text-transform:none;">
                                            <?=$sch['day_of_the_week'] ?? ''?> | 
                                            <?= (isset($sch['start_time'])) ? date('h:i a', strtotime($sch['start_time'])).' to ' : '';?>
                                            <?= (isset($sch['end_time'])) ? date('h:i a', strtotime($sch['end_time'])).' to ' : '';?>|
                                            <?=strtoupper($sch['room_details'] ?? '')?>
                                            </li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td><a class="btn" href="attendance.php?id=<?=$row['class_id']?>">Attendance</a></td>
                            <td><a class="btn" href="reports.php?id=<?=$row['class_id']?>">Report</a></td>
                            <td><a class="btn" href="viewstudents.php?id=<?=$row['class_id']?>">Students</a></td>
                            <td><a class="btn" href="seatplan.php?id=<?=$row['class_id']?>">View</a></td>
                        </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr>
                        <td colspan="7">
                            <center>
                                No assigned subject found.
                            </center>
                        </td>
                    </tr>
                <?php endif;?>
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
    <script>
        $(function(){
            $('#semester_id').addClass('form-control h-100');

            $('#semester_id').on('change', function(){
                $('#form').trigger('submit');
            });
      });
    </script>
    <?php if(isset($_POST['semester_id'])):?>
        <script>
            $('#semester_id').val(<?=$_POST['semester_id']?>);
        </script>
    <?php endif;?>
</body>

</html>