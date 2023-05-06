<?php
if(isset($_POST["btnsave"])){
    $coursecode = $_POST["txtcoursecode"];
    $coursedescription = $_POST["txtcoursedescription"];


    if($coursecode == ""){
      echo "Please input valid Student ID!";
    }elseif($coursedescription == ""){
      echo "Please input valid Name!";
    }else{

    require("config/db_connect.php");


      $sql = "INSERT INTO tblcourse (coursecode, coursedescription) VALUES(:coursecode, :coursedescription)";
        
        $result = $conn->prepare($sql);
        $values = array("coursecode" => $coursecode, "coursedescription" => $coursedescription);
    
        $result->execute($values);
    
        if($result->rowCount()>0){
            echo "<script>alert('Record has been saved'); window.location = 'course.php';</script>";
        }else{
            echo "<script>alert('No record has been saved');</script>";
        }
    }
  }
?>

