<?php
session_start();

@include '../config/db_connection.php';
@include '../roomhandler/room_eventhandler.php';

$_conn = new ConnectionHandler();
$_room = new Room($_conn);

if (isset($_POST["btnsave"])) {
  // This are the data required
  $fk_semester_id = $_POST["semesterID"];
  $fk_instructor_id = $_POST["InstructorId"];
  $fk_subject_id = $_POST["subject"];
  $room = $_POST["room"];
  $to_time = $_POST["totime"];
  $from_time = $_POST["fromtime"];

  // fast if else condition
  // Condition ? True : False;
  echo ($_room->addRoomManagement($fk_semester_id,  $fk_instructor_id, $fk_subject_id, $room, $to_time, $from_time)) ?
    header("Location: ../../roommanegement.php") :
    "<div>Fail to upload Student Information</div>";
}
