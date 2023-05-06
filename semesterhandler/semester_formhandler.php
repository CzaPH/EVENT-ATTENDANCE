<?php
session_start();

@include '../config/db_connection.php';
@include '../semesterhandler/semesterevent_handler.php';

$_conn = new ConnectionHandler();
$_semester = new Semester($_conn);

if (isset($_POST["btnsave"]))
{
  // This are the data required
  $semester_code = $_POST["txtsemester_code"];
  $semester_description = $_POST["txtsemester_description"];
  $semester_year = $_POST["txtsemester_year"];
  $semester_info = $_POST["txtsemester_info"];
  $semester_status = $_POST["txtsemester_status"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_semester->addSemester($semester_code, $semester_description, $semester_year, $semester_info, $semester_status))?
    header("Location: ../../semester.php"):
    "<div>Fail to upload Semester Information</div>";

} 