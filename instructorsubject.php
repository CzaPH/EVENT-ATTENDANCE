<?php

if (isset($_POST["btnsave"])) {
  $fk_instructor_id = $_POST["txtfk_instructor_id"];
  $fk_subject_id = $_POST["txtfk_subject_id"];
  $fk_course_id = $_POST["txtfk_course_id"];
  $fk_year_id = $_POST["txtfk_year_id"];
  $fk_section_id = $_POST["txtfk_section_id"];

  if ($fk_instructor_id == "") {
    echo "Please input valid Student ID!";
  } elseif ($fk_subject_id == "") {
    echo "Please input valid Name!";
  } elseif ($fk_course_id == "") {
    echo "Please input valid Name!";
  } elseif ($fk_year_id == "") {
    echo "Please input valid Name!";
  } elseif ($fk_section_id == "") {
    echo "Please input valid sex!";
  }else {

    require("config/db_connect.php");


    $sql = "INSERT INTO tblsubjectassign (fk_instructor_id, fk_subject_id, fk_course_id, fk_year_id, fk_section_id) VALUES(:fk_instructor_id, :fk_subject_id, :fk_course_id, :fk_year_id, :fk_section_id)";

    $result = $conn->prepare($sql);
    $values = array("fk_instructor_id" => $fk_instructor_id, "fk_subject_id" => $fk_subject_id, "fk_course_id" => $fk_course_id, "fk_year_id" => $fk_year_id, "fk_section_id" => $fk_section_id);

    $result->execute($values);

    if ($result->rowCount() > 0) {
      echo "<script>alert('Record has been saved'); window.location = 'instructor.php';</script>";
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
  <title>Add New Record</title>
  <link rel="stylesheet" href="css/add_record.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
  <div class="container">
    <!--main page-->
    <section class="main">
      <div class="main-top">
        <h1>College of Computing Studies, Information and Communication Technology</h1>
      </div>

      <div class="form-container">
        <form action="instructorsubject.php" method="post">
          <h3>Add New Student Details</h3>


          <select name="txtfk_instructor_id">
            <option value="cboinstructor">Intructor Name</option>
            <?php
            function instructorOption()
            {
              require("config/db_connect.php");

              $instructor = $conn->prepare("SELECT id, fname, lname FROM tblinstructor");
              $instructor->execute();

              $ans = $instructor->setFetchMode(PDO::FETCH_ASSOC);

              while ($instructorid = $instructor->fetch()) {
                extract($instructorid);
                echo "<option value='$id'>$fname $lname</option>";
              }
            }
            instructorOption();
            ?>
          </select>

          <select name="txtfk_subject_id">
            <option value="cbosubject">Subject</option>
            <?php
            function subjectOption()
            {
              require("config/db_connect.php");

              $subject = $conn->prepare("SELECT id, subject_code FROM tblsubject");
              $subject->execute();

              $ans = $subject->setFetchMode(PDO::FETCH_ASSOC);

              while ($subjectid = $subject->fetch()) {
                extract($subjectid);
                echo "<option value='$id'>$subject_code</option>";
              }
            }
            subjectOption();
            ?>
          </select>

          <select name="txtfk_course_id">
            <option value="cbocourse">Course</option>
            <?php
            function courseOption()
            {
              require("config/db_connect.php");

              $course = $conn->prepare("SELECT id, coursecode FROM tblcourse");
              $course->execute();

              $ans = $course->setFetchMode(PDO::FETCH_ASSOC);

              while ($courseid = $course->fetch()) {
                extract($courseid);
                echo "<option value='$id'>$coursecode</option>";
              }
            }
            courseOption();
            ?>
          </select>

          <select name="txtfk_year_id">
            <option value="cboyear">Year</option>
            <?php
            function yearOption()
            {
              require("config/db_connect.php");

              $year = $conn->prepare("SELECT id, year_code FROM tblyear");
              $year->execute();

              $ans = $year->setFetchMode(PDO::FETCH_ASSOC);

              while ($yearid = $year->fetch()) {
                extract($yearid);
                echo "<option value='$id'>$year_code</option>";
              }
            }
            yearOption();
            ?>
          </select>

          <select name="txtfk_section_id">
            <option value="cbosection">Section</option>
            <?php
            function sectionOption()
            {
              require("config/db_connect.php");

              $section = $conn->prepare("SELECT id, section_code FROM tblsection");
              $section->execute();

              $ans = $section->setFetchMode(PDO::FETCH_ASSOC);

              while ($sectionid = $section->fetch()) {
                extract($sectionid);
                echo "<option value='$id'>$section_code</option>";
              }
            }
            sectionOption();
            ?>
          </select>


          <input type="submit" name="btnsave" value="Save" class="form-btn">
          <li>
            <a href="instructor.php">
              <i class='bx bx-arrow-back'></i>
              <span class="links_name"> Back</span>
            </a>
          </li>
        </form>
      </div>
</body>
</html>