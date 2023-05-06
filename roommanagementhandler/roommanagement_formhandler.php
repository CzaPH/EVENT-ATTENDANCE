<?php
session_start();

@include '../config/db_connection.php';
@include '../roomnagementhandler/roommanagement_eventhandler.php';

$_conn = new ConnectionHandler();
$_roommanagenent = new RoomManagement($_conn);

if (isset($_POST["btnsave"])) {
  // This are the data required
  $fk_semester_id = $_POST["semesterid"];
  $fk_instructor_id = $_POST["instructorid"];
  $fk_subject_id = $_POST["subjectid"];
  $fk_room_id = $_POST["roomid"];
  $to_time = $_POST["totime"];
  $from_time = $_POST["fromtime"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_room->addRoomManagement($fk_semester_id,  $fk_instructor_id, $fk_subject_id, $fk_room_id, $to_time, $from_time)) ?
    header("Location: ../../roommanegement.php") :
    "<div>Fail to upload Student Information</div>";
}
