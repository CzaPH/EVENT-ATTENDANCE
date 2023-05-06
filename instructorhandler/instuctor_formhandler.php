<?php
session_start();

@include '../config/db_connection.php';
@include '../instructorhandler/instructor_eventhandler.php';

$_conn = new ConnectionHandler();
$_instructor = new Instructor($_conn);

if (isset($_POST["btnsave"]))
{
  // This are the data required
  $employee_number = $_POST["txtemployee_number"];
  $fname= $_POST["txtfname"];
  $mname= $_POST["txtmname"];
  $lname= $_POST["txtlname"];
  $employee_password = $_POST["txtemployee_password"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_instructor->addIntructor($employee_number, $fname, $mname, $lname, $employee_password))?
    header("Location: ../../instructor.php"):
    "<div>Fail to upload Instructor Information</div>";

} 