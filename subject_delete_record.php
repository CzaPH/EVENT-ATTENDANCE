<?php
// if(isset($_REQUEST["id"])){
//     require("config/db_connect.php");

//     $id = $_REQUEST["id"];

//     // $sql = "DELETE FROM tblsubject WHERE id = :recordid";
//     $sql = "UPDATE tblsubject set is_deleted = 1 where id = :recordid";

//     $result = $conn->prepare($sql);
//     $values = array(":recordid" => $id);

//     $result -> execute($values);

//     if($result->rowCount()>0){
//         echo "<script>alert('Record has been deleted!'); window.location='subject.php';</script>";

//     }else{
//         echo "<script>alert('No record has been deleted!'); window.location='subject.php';</script>";
//     }

// }

include("config/config.php");

if (isset($_POST['delete'])) {
  $subject_id = filter($_POST['subject_id']);

  $delete = $conn->prepare("DELETE FROM tblsubject WHERE id = ?");
  $delete->bind_param("i", $subject_id);
  $delete->execute();

  exit(json_encode('success'));
}
include('header.php');
?>