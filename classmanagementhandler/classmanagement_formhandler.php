<?php
session_start();

@include '../config/db_connection.php';
@include '../classnagementhandler/classmanagement_eventhandler.php';

$_conn = new ConnectionHandler();
$_classmanagement = new ClassManagement($_conn);

if (isset($_POST["btnsave"])) {
  // This are the data required
  $fk_student_id = $_POST["student_id"];
  $fk_student_name = $_POST["student_name"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_classmanagement->addClassManagement($fk_student_id,  $fk_student_name)) ?
    header("Location: ../../classmanegement.php") :
    "<div>Fail to upload Class Information</div>";
}
