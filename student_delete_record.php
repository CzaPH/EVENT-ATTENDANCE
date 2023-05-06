<?php
// if(isset($_REQUEST["id"])){
//     require("config/db_connect.php");

//     $id = $_REQUEST["id"];

//     $sql = "UPDATE tblstudentinfo set is_deleted = 1 where id = :recordid";
//     $result = $conn->prepare($sql);
//     $values = array(":recordid" => $id);

//     $result -> execute($values);

//     if($result->rowCount()>0){
//         echo "<script>alert('Record has been deleted!'); window.location='student.php';</script>";

//     }else{
//         echo "<script>alert('No record has been deleted!'); window.location='student.php';</script>";
//     }

// }
include("config/config.php");

if (isset($_POST['delete'])) {
  $student_id = filter($_POST['student_id']);

  $delete = $conn->prepare("DELETE FROM tblstudentinfo WHERE id = ?");
  $delete->bind_param("i", $student_id);
  $delete->execute();

  exit(json_encode('success'));
}
include('header.php');
?>
?>