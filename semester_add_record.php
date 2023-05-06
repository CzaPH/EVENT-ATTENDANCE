<?php


if(isset($_POST["btnsave"])){
    $semester_code = $_POST["txtsemester_code"];
    $semester_description = $_POST["txtsemester_description"];
    $semester_year = $_POST["txtsemester_year"];
    $is_active = false;

    if($semester_code == ""){
      echo "Please input valid Student ID!";
  }elseif($semester_description == ""){
      echo "Please input valid Name!";
  }elseif($semester_year == ""){
      echo "Please input valid Name!";
  }else{

    require("config/db_connect.php");


      $sql = "INSERT INTO tblsemester (semester_code, semester_description, semester_year, is_active) VALUES(:semester_code, :semester_description, :semester_year, :is_active)";
        
        $result = $conn->prepare($sql);
        $values = array("semester_code" => $semester_code, "semester_description" => $semester_description, "semester_year" => $semester_year, "is_active" => $is_active);
    
        $result->execute($values);
    
        if($result->rowCount()>0){
            echo "<script>alert('Record has been saved'); window.location = 'semester.php';</script>";
        }else{
            echo "<script>alert('No record has been saved');</script>";
        }
    }
  }
?>