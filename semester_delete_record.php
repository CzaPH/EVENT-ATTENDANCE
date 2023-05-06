<?php
// if(isset($_REQUEST["id"])){
//     require("config/db_connect.php");

//     $id = $_REQUEST["id"];

//     $sql = "UPDATE tblsemester set is_deleted = 1 where id = :recordid";
    
//     $result = $conn->prepare($sql);
//     $values = array(":recordid" => $id);

//     $result -> execute($values);

//     if($result->rowCount()>0){
//         echo "<script>alert('Record has been deleted!'); window.location='semester.php';</script>";

//     }else{
//         echo "<script>alert('No record has been deleted!'); window.location='semester.php';</script>";
//     }

// }
include("config/config.php");

if (isset($_POST['delete'])) {
  $semester_id = filter($_POST['semester_id']);

  $delete = $conn->prepare("DELETE FROM tblsemester WHERE id = ?");
  $delete->bind_param("i", $semester_id);
  $delete->execute();

  exit(json_encode('success'));
}
include('header.php');
?>