<?php
//DEBUG
//ECHO $_GET['id'];
require("config/db_connect.php");
?>
<?php
if(isset($_POST["btnsave"])){
    $fk_student_id = $_GET['id'];
    $fk_subject_id = $_POST["txtSubject"];
    $time_id = $_POST["txtTime"];
    $duration_id = $_POST["txtDuration"];
 
      if ($fk_subject_id == "") {
        echo "Please input valid Time!";
      } elseif ($time_id == "") {
        echo "Please input valid Time!";
      } elseif ($duration_id == "") {
        echo "Please input valid Time!";
      } else {

        require("config/db_connect.php"); 
 
     $sql = "INSERT INTO tbl_student_add_subject (fk_student_id, fk_subject_id, time_id, duration_id)
     VALUES(:fk_student_id, :fk_subject_id, :time_id, :duration_id)";

        /*DEBUG
          $sql = "INSERT INTO tbl_add_subject (fk_student_id, fk_subject_id, time_id, duration_id)
       VALUES($fk_student_id, $fk_subject_id, $time_id, $duration_id)";*/

        //DEBUG
          //echo ($sql);
        
      $result = $conn->prepare($sql);
      $values = array("fk_student_id" => $fk_student_id, "fk_subject_id" => $fk_subject_id, "time_id" => $time_id, "duration_id" => $duration_id);
    
        $result->execute($values);
    
       if($result->rowCount()>0){
           echo "<script>alert('Record has been saved'); window.location = 'student_assigning.php?id= ".$_GET['id'] ."';</script>";
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
        <a href="student.php">
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
        <span class="dashboard">Assigning student Subject</span>
</div>
    </nav>
    <div class="home-content">
      <section class="attendance">
        <div class="attendance-list">
        <div class="row">
          <div class="col-2 text-truncate">
          
          </div>
        </div>
        <form action="student_assigning.php?id=<?php echo $_GET['id']?>" method="POST">
            <div class="row">

      <!-- <input type="hidden" name="stduentID"  value ="<?php $_GET['id']?>"/> --> 
    
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
            <option value="07:00 PM">07:00 PM</option>
            <option value="08:00 PM">08:00 PM</option>
            <option value="08:30 PM">08:30 PM</option>
            <option value="09:00 PM">09:00 PM</option>
            <option value="10:00 PM">10:00 PM</option>
            <option value="11:00 PM">11:00 PM</option>
            <option value="12:00 AM">12:00 AM</option>
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
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="btnsave" value="Assign Subject" class="form-btn">
</div>
  
</form>
          <table class="table">
            <thead>
            <!-- <tr><th></th></tr> -->
              <tr>
                <th>#</th>
                <th>Student ID No.</th>
                <th>Name</th>
                <th>Subjects</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               <!--PHP CODE HERE GETTING/LISTING ALL THE RECORDS AVAILABLE IIN THE-->
              <?php
              $numid = $_REQUEST['id'];
                            //$sql = "SELECT * FROM tblinstructor WHERE id = $id";
                            
               $sql = "SELECT B.stud_id, B.fname, B.mname, B.lname, C.subject_code, C.subject_description, A.time_id, A.duration_id, A.id
               FROM tbl_student_add_subject AS A
               INNER JOIN tblstudentinfo AS B ON A.fk_student_id = B.id 
               INNER JOIN tblsubject AS C ON A.fk_subject_id = C.id WHERE A.fk_student_id = $numid";
               

                $res = $conn->prepare($sql);
                $res->execute();

                $i = 1;
                if ($res->rowCount() > 0) {
                    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                <td>" . $i . "</td>
                <td>" . $row['stud_id'] . "</td>
                <td>" . $row['lname'] . ", " . $row['fname'] . " " . $row['mname'] . "</td>
                <td>" . $row['subject_code'] . " " . $row['subject_description'] . "</td>
                <td>" . $row['time_id'] . "</td>
                <td>" . $row['duration_id'] . "</td>
                <td><a href = 'student_edit_record.php?id=" . $row['id'] . "'><i class='fas fa-edit' style='font-size:24px;color:black'></i></a> | ";
                ?>

                <a href='student_subject_delete.php?delete_id=<?php echo $row['id']; ?>&return_id=<?php echo $_GET['id']?>' onClick="return confirm('are you sure you want to delete this?');"><i class='far fa-trash-alt' style='font-size:24px;color:red'></i></a></td>
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