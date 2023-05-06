<?php
require("config/db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/sidebar.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Document</title>
</head>

<body>

    <div class="sidebar">
        <div class="logo-details">
            <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="instructor.php">
                    <i class='bx bx-arrow-back'></i>
                    <span class="links_name">Back</span>
                </a>
            </li>

        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">Students in Subject</span>
            </div>
        </nav>
        <div class="home-content">
            <section class="attendance">
                <div class="attendance-list">
                <a href="studentsubject.php" class="btn"> <i class='bx bx-plus'></i>Assign Students</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Subject</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            $id = $_REQUEST['id'];
                            /*$sql = "SELECT tblsubjectassign.id as id,tblstudentinfo.stud_id AS stud_id,tblstudentinfo.fname as fname,tblstudentinfo.mname as mname,tblstudentinfo.lname as lname,
                            tblsubjectassign.fk_course_id as course,tblsubjectassign.fk_year_id as year,tblsubjectassign.fk_section_id as section FROM tblsubjecttostudent
                            INNER JOIN tblsubjectassign ON tblsubjecttostudent.fk_subjectassign_id = tblsubjectassign.id
                            INNER JOIN tblstudentinfo ON tblsubjecttostudent.fk_studentassign_id = tblstudentinfo.id
                            WHERE tblsubjectassign.fk_course_id = tblstudentinfo.fk_course_id AND tblstudentinfo.fk_year_id AND tblstudentinfo.fk_section_id";*/
                            $sql = "SELECT tbl_add_subject.id,tbl_add_subject.fk_student_id as student_id,tbl_add_subject.fk_subject_id as subject, tbl_add_subject.time_id as time,tbl_add_subject.duration_id as duration
                            FROM `tbl_add_subject` INNER JOIN tblsubjectassign ON tbl_add_subject.fk_subject_id = tblsubjectassign.id 
                            WHERE tbl_add_subject.fk_subject_id = tblsubjectassign.fk_subject_id AND $id";


                            $res = $conn->prepare($sql);
                                          $res->execute();
                            
                                          $i = 1;
                                          if ($res->rowCount() > 0) {
                                            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                                              echo "<tr>
                                            <td>" . $i . "</td>
                                            <td>" . $row['student_id'] . "</td>
                                            <td>" . $row['subject'] . "</td>
                                            <td>" . $row['time'] . "</td>
                                            <td>" . $row['duration'] . "</td>

                                            <td><a href = 'edit_record.php?id=" . $row['id'] . "'><i class='fas fa-edit' style='font-size:24px;color:black'></i></a> | ";
                                          ?>
                            
                                              <a href='delete_record.php?id=<?php echo $row['id']; ?>' onClick="return confirm('are you sure you want to delete this?');"><i class='far fa-trash-alt' style='font-size:24px;color:red'></i></a></td>
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
            </section>

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