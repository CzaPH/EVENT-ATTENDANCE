<?php
//DEBUG
//ECHO $_GET['id'];
require("config/db_connect.php");
?>
<?php
if(isset($_POST["btnsave"])){
    $fk_instructor_id = $_GET['id'];
    $fk_subject_id = $_POST["txtSubject"];
    $time = $_POST["txtTime"];
    $duration = $_POST["txtDuration"];
    $fk_course_id = $_POST["txtCourse"];
    $fk_year = $_POST["txtYear"];
    $fk_section = $_POST["txtSection"];


   
      if ($fk_subject_id == "") {
        echo "Please input valid Time!";
      } elseif ($time == "") {
        echo "Please input valid Time!";
      } elseif ($duration == "") {
        echo "Please input valid Time!";
      } else {

        require("config/db_connect.php"); 
 
     $sql = "INSERT INTO tbl_faculty_add_subject (fk_instructor_id, fk_subject_id, time, duration, fk_course_id, fk_year, fk_section)
     VALUES(:fk_instructor_id, :fk_subject_id, :time, :duration, :fk_course_id, :fk_year, :fk_section)";

// $sql = "INSERT INTO tbl_faculty_add_subject (fk_instructor_id, fk_subject_id, time, duration, fk_course_id, fk_year, fk_section)
// VALUES($fk_instructor_id, $fk_subject_id, $time, $duration, $fk_course_id, $fk_year, $fk_section)";

    //  echo $sql;
  
      $result = $conn->prepare($sql);
      $values = array("fk_instructor_id" => $fk_instructor_id, "fk_subject_id" => $fk_subject_id, "time" => $time, "duration" => $duration,
       "fk_course_id" => $fk_course_id, "fk_year" => $fk_year, "fk_section" => $fk_section);
    
        $result->execute($values);
    
       if($result->rowCount()>0){
           echo "<script>alert('Record has been saved'); window.location = 'instructor_subject_assign.php?id= ".$_GET['id'] ."';</script>";
        }else{
           echo "<script>alert('No record has been saved');</script>";
        }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Semester Information</title>
  <link rel="stylesheet" href="css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
        <span class="dashboard">Instructor Subject Assign</span>
      </div>
      <form onsubmit="return ajsearch();">
        <input type="text" id="search" required />
        <input type="submit" value="Search" />
      </form>
    </nav>

    <div class="home-content">
      <section class="attendance">
        <div class="attendance-list">
        <form action="instructor_subject_assign.php?id=<?php echo $_GET['id']?>" method="POST">
            <div class="row">
      <div class="col-md-2 mb-2">
    <label for="Course">Course:</label>
    <select name="txtCourse" class="col-md-8 mb-3" required>
            <option value="cbosubject">Course </Section></option>
            <?php
            function courseOption()
            {
              require("config/db_connect.php");

              $course = $conn->prepare("SELECT id, coursecode FROM tblcourse WHERE is_deleted = '0'");
              $course ->execute();

              $ans = $course ->setFetchMode(PDO::FETCH_ASSOC);

              while ($courseid = $course ->fetch()) {
                extract($courseid);
                echo "<option value='$id'>$coursecode</option>";
              }
            }
            courseOption();
            ?>
          </select>
          </div>
          <div class="col-md-2 mb-2">
    <label for="Course">Year:</label>
    <select name="txtYear" class="col-md-8 mb-3" required>
            <option value="cbosubject">Year </Section></option>
            <?php
            function yearOption()
            {
              require("config/db_connect.php");

              $year = $conn->prepare("SELECT id, year_code, year_description FROM tblyear");
              $year ->execute();

              $ans = $year ->setFetchMode(PDO::FETCH_ASSOC);

              while ($yearid = $year ->fetch()) {
                extract($yearid);
                echo "<option value='$id'>$year_description</option>";
              }
            }
            yearOption();
            ?>
          </select>
          </div>

          <div class="col-md-2 mb-2">
    <label for="Course">Section:</label>
    <select name="txtSection" class="col-md-8 mb-3" required>
            <option value="cbosubject">Section </Section></option>
            <?php
            function sectionOption()
            {
              require("config/db_connect.php");

              $year = $conn->prepare("SELECT id, section_code FROM tblsection");
              $year ->execute();

              $ans = $year ->setFetchMode(PDO::FETCH_ASSOC);

              while ($yearid = $year ->fetch()) {
                extract($yearid);
                echo "<option value='$id'>$section_code</option>";
              }
            }
            sectionOption();
            ?>
          </select>
          </div>

    <div class="col-md-4 mb-3">
    <label for="Course">Subject:</label>
    <select name="txtSubject" class="col-md-8 mb-3" required>
            <option value="cbosubject">Subject</option>
            <?php
            function subjectOption()
            {
              require("config/db_connect.php");

              $subject = $conn->prepare("SELECT id, subject_code, subject_description FROM tblsubject WHERE is_deleted = '0'");
              $subject ->execute();

              $ans = $subject ->setFetchMode(PDO::FETCH_ASSOC);

              while ($subjectid = $subject ->fetch()) {
                extract($subjectid);
                echo "<option value='$id'>$subject_code - $subject_description</option>";
              }
            }
            subjectOption();
            ?>
          </select>
    </div>
    <div class="col-md-4 mb-3">
    <label for="Course">Start Time:</label>
    <select name="txtTime" class="col-md-6 mb-3" required>
            <option value="cbostarttime">Start time</option>
            <option value="7:00 AM">7:00 AM</option>
            <option value="8:00 AM">8:00 AM</option>
            <option value="9:00 AM">9:00 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="01:00 PM">01:00 PM</option>
            <option value="02:00 PM">02:00 PM</option>
            <option value="03:00 PM">03:00 PM</option>
            <option value="04:00 PM">04:00 PM</option>
            <option value="05:00 PM">05:00 PM</option>
            <option value="06:00 PM">06:00 PM</option>
            ?>
          </select>
    </div>
    <div class="col-md-4 mb-3">
    <label for="Course">Duration:</label>
    <select name="txtDuration" class="col-md-6 mb-3" required>
            <option value="cbostarttime">Duration</option>
            <option value="30 minutes">30 minutes</option>
            <option value="1 hour">1 hour</option>
            <option value="2 hours">2 hours</option>
            <option value="3 hours">3 hours</option>
            <option value="4 hours">4 hours</option>
            <option value="5 hours">5 hours</option>
            <option value="6 hours">6 hours</option>
          </select>
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="submit" name="btnsave" value="Assign Subject" class="form-btn">
</div>
  
</form>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Course Year & Section</th>
                <th>Subjects</th>
                <th>Time</th>
                <th>Duration</th>
                <th>View Student</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               <!--PHP CODE HERE GETTING/LISTING ALL THE RECORDS AVAILABLE IIN THE-->
              <?php
              $numid = $_REQUEST['id'];
                            //$sql = "SELECT * FROM tblinstructor WHERE id = $id";
                            
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
                <td><a href = 'instructor_view_list.php?id=" . $row['subject_id'] . "'>View Student</a> </td>
                <td><a href = 'student_edit_record.php?id=" . $row['id'] . "'><i class='fas fa-edit' style='font-size:24px;color:black'></i></a> | ";
                ?>

          <a href='instructor_subject_delete.php?delete_id=<?php echo $row['id']; ?>&return_id=<?php echo $_GET['id']?>' onClick="return confirm('are you sure you want to delete this?');"><i class='far fa-trash-alt' style='font-size:24px;color:red'></i></a></td>
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