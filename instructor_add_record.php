<?php
    require("config/db_connect.php");
if (isset($_POST["btnsave"])) {
  $employee_number = $_POST["txtemployee_number"];
  $fname = $_POST["txtfname"];
  $mname = $_POST["txtmname"];
  $lname = $_POST["txtlname"];
   $password = md5($_POST['password']);
   $user_type = 'Faculty';

     $sql = "INSERT INTO tblinstructor (employee_number, fname, mname, lname, `password`, user_type) VALUES(:employee_number, :fname, :mname, 
    :lname, :password, :user_type)";

    $result = $conn->prepare($sql);
    $values = array("employee_number" => $employee_number, "fname" => $fname, "mname" => $mname, "lname" => $lname, "password" => $password, "user_type" => $user_type);

    $result->execute($values);

    if ($result->rowCount() > 0) {
      echo "<script>alert('Record has been saved'); window.location = 'instructor.php';</script>";
    } else {
      echo "<script>alert('No record has been saved');</script>";
    }
  }
?>