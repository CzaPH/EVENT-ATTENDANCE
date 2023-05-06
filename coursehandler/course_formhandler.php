<?php
session_start();

@include '../config/db_connection.php';
@include '../coursehandler/course_eventhandler.php';

$_conn = new ConnectionHandler();
$_course = new Course($_conn);

if (isset($_POST["btnsave"]))
{
  // This are the data required
  $coursecode = $_POST["txtcoursecode"];
  $coursedescription= $_POST["txtcoursedescription"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_course->addCourse($coursecode, $coursedescription))?
    header("Location: ../../course.php"):
    "<div>Fail to upload Course Information</div>";

} 