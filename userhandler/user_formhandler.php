<?php
session_start();

@include '../config/db_connection.php';
@include '../userhandler/user_eventhandler.php';

$_conn = new ConnectionHandler();
$_user = new User($_conn);

if (isset($_POST["btnsave"]))
{
  // This are the data required
  $fname= $_POST["txtfname"];
  $mname= $_POST["txtmname"];
  $lname= $_POST["txtlname"];
  $user_id= $_POST["txtuser_id"];
  $password = $_POST["txtpassword"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_User->addUser($employee_number, $fname, $mname, $lname, $employee_password))?
    header("Location: ../../user.php"):
    "<div>Fail to upload User Information</div>";

} 