<?php
require("config/db_connect.php");

if (isset($_POST["btnsave"])) {
  $id = $_POST["id"];
  $stud_id = $_POST["txtstudid"];
  $fname = $_POST["txtfname"];
  $sex = $_POST["txtsex"];
  $course = $_POST["txtcourse"];
  $year_and_section = $_POST["year_and_section"];
  $cys = strtoupper($course).' '.$year_and_section;

  if ($stud_id == "") {
    echo "Please input valid Student ID!";
  } elseif ($fname == "") {
    echo "Please input valid Name!";
  } elseif ($sex == "") {
    echo "Please input valid sex!";
  } else {


    $sql = "UPDATE tblstudentinfo SET stud_id=:stud_id, fname=:fname, 
                    sex=:sex, course = :course,
                    year_and_section = :year_and_section, cys = :cys 
                    WHERE id = :recordid";

    $result = $conn->prepare($sql);
    $values = array(":stud_id" => $stud_id, ":fname" => $fname, ":sex" => $sex, ":course" => $course, 
                    ":year_and_section" => $year_and_section, ":cys" => $cys, 
                    ":recordid" => $id);

    $result->execute($values);

    if ($result->rowCount() > 0) {
      echo "<script>alert('Record has been saved'); window.location = 'student.php';</script>";
    } else {
      echo "<script>alert('No record has been saved');</script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit & Update Student Record</title>
  <link rel="stylesheet" href="css/add_record.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
  <div class="container">

    <!--main page-->
    <section class="main">
      <div class="main-top">
        <h1>College of Computing Studies, Information and Communication Technology</h1>
      </div>

      <div class="form-container">
        <!--php code-->
        <?php

        $sql = "SELECT * FROM tblstudentinfo WHERE id = :recordid";

        $id = "";
        $stud_id = "";
        $fname = "";
        $mname = "";
        $lname = "";
        $sex = "";

        try {
          $res = $conn->prepare($sql);
          $value = array(":recordid" => $_REQUEST["id"]);

          try {
            $res->execute($value);
            if ($res->rowCount() > 0) {

              $row = $res->fetch(PDO::FETCH_ASSOC);
              $id = $row["id"];
              $stud_id  = $row["stud_id"];
              $fname = $row["fname"];
              $sex = $row["sex"];
              $course = $row["course"];
              $year_and_section = $row["year_and_section"];
            }
          } catch (PDOException $e) {
            die("An Error has been occured!");
          }
        } catch (PDOException $e) {
          die("An Error has been occured!");
        }
        ?>
        <form action="student_edit_record.php" method="post">
          <input type="hidden" name="id" value="<?php echo "$id" ?>">
          <h3>Edit & Update Student Record</h3>
          <label>Student ID Number:<br>
          <input type="text" value="<?php echo "$stud_id" ?>" name="txtstudid" required placeholder="Enter student ID #">
          <label>Complete Name:<br>
          <input type="text" value="<?php echo "$fname" ?>" name="txtfname" required placeholder="Enter student complete name">
          <label>Sex:<br>
          <select name="txtsex" value="<?php echo "$sex" ?>">
            <option value="Sex">Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <label>Course:<br>
          <select name="txtcourse" id="course">
            <option value="">Course</option>
            <?php
            function courseOption()
            {
              require("config/db_connect.php");

              $course = $conn->prepare("SELECT id, coursecode FROM tblcourse WHERE is_deleted = '0'");
              $course->execute();

              $ans = $course->setFetchMode(PDO::FETCH_ASSOC);

              while ($courseid = $course->fetch()) {
                extract($courseid);
                echo "<option value='$coursecode'>$coursecode</option>";
              }
            }
            courseOption();
            ?>
          </select>
          <label>Yr. &amp; Section:</label>
          <input type="text" name="year_and_section" value="<?php echo $year_and_section ?>" required placeholder="Enter year and section" class = "form-control">

          <input type="submit" name="btnsave" value="Save" class="form-btn">
          <li>
            <a href="student.php">
              <i class='bx bx-arrow-back'></i>
              <span class="links_name"> Back</span>
            </a>
          </li>
        </form>
      </div>
<script>
    $(function(){
        $('#course').val('<?=$course?>');
    });
</script>
</body>

</html>