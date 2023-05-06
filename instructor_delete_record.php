<?php
// if(isset($_REQUEST["id"])){
//     require("config/db_connect.php");

//     $id = $_REQUEST["id"];

//     $sql = "UPDATE tblinstructor set is_deleted = 1 where id = :recordid";
    
//     $result = $conn->prepare($sql);
//     $values = array(":recordid" => $id);

//     $result -> execute($values);

//     if($result->rowCount()>0){
//         echo "<script>alert('Record has been deleted!'); window.location='instructor.php';</script>";

//     }else{
//         echo "<script>alert('No record has been deleted!'); window.location='instructor.php';</script>";
//     }

// }
include("config/config.php");

if (isset($_POST['delete'])) {
  $instructor_id = filter($_POST['instructor_id']);

  $delete = $conn->prepare("DELETE FROM tblinstructor WHERE id = ?");
  $delete->bind_param("i", $instructor_id);
  $delete->execute();

  exit(json_encode('success'));
}
include('header.php');
?>