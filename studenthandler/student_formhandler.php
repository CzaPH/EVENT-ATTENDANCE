<?php
session_start();

@include '../config/db_connection.php';
@include '../studenthandler/studentevent_handler.php';

$_conn = new ConnectionHandler();
$_student = new Student($_conn);

if (isset($_POST["btnsave"])) {
  // This are the data required
  $stud_id = $_POST["txtstudid"];
  $fname = $_POST["txtfname"];
  $mname = $_POST["txtmname"];
  $lname = $_POST["txtlname"];
  $sex = $_POST["txtsex"];
  $fk_course_id = $_POST["txtcourse"];
  $fk_section_id = $_POST["txtsection"];
  $fk_year_id = $_POST["txtyear"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_student->addStudent($stud_id, $fname, $mname, $lname, $sex, $fk_course_id, $fk_section_id, $fk_year_id)) ?
    header("Location: ../../student.php") :
    "<div>Fail to upload Student Information</div>";
}
