<?php
session_start();

@include '../config/db_connection.php';
@include '../subjecthandler/subject_eventhandler.php';

$_conn = new ConnectionHandler();
$_subject = new Subject($_conn);

if (isset($_POST["btnsave"]))
{
  // This are the data required
  $subject_code = $_POST["txtsubject_code"];
  $subject_description = $_POST["txtsubject_description"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_subject->addSubject($subject_code, $subject_description))?
    header("Location: ../../subject.php"):
    "<div>Fail to upload Subject Information</div>";

} 