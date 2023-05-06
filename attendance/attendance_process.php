<?php

/*
  collect data from table which class is listed where the student id matches
  compare the current time to the time where student has class:
    if student has class compare log ins
      if log in is in for the class cancel
      else log in student on their class
    else remind the student that they have no class
  check student class they  are attending

  If student scan qr code at 15 minutes late. System will mark that student as absent
  if student scan qr cod at 0 minutes late. System will mark that as late
*/

function timeConvert($time) {
  $convertedTime = (int)filter_var($time, FILTER_SANITIZE_NUMBER_INT);
  $convertedTime = (strpos($time, "AM")) ? $convertedTime : $convertedTime + 10000;

  return $convertedTime;
}
// kakasen
function login($conn,$emp, $time, $date, $subject) {
  $stmt = $conn->prepare("INSERT INTO tblattendance(fk_student_id,time_in,logdate,fk_subject_id) VALUES ('$emp', '$time', '$date', '$subject')");
  $result = $stmt->execute();
  // Debug
  //  echo $stmt = ("INSERT INTO tblattendance(fk_student_id,time_in,logdate,fk_subject_id) VALUES ('$emp', '$time', '$date', '$subject')");
  if($result == TRUE){
    echo "<div class='alert alert-success' role='alert' style='font-size:22px'><h4><i class='fa fa-clock'></i>  Time In</h4><b>Your Time In: </b> ".$time." in ".$subject."</div>";
  }else{
      echo "<div class='alert alert-danger' role='alert'>Error</div>";  
  }
}

function sqlCommand($sql, $conn) {
  //echo $sql."<br/>";
  $res = $conn->prepare($sql);
  $res->execute();
  return $res;
}

require("../config/db_connect.php");
if (isset($_POST['student_id'])) {
  date_default_timezone_set("asia/manila");
  $emp = trim($_POST['student_id']);
  $date = date('Y-m-d');
  //$time = date('h:i A');
  $time = date('h:i:A', strtotime("+0 HOURS"));
  $stat = 0;
  $stat2 = 1;

  // sql code which check student_id exist in the database
  $res = sqlCommand("SELECT * FROM tblstudentinfo WHERE stud_id = '$emp'", $conn);

   if ($res->rowCount() <= 0) {
       echo "<div class='alert alert-warning' role='alert' style='font-size:18px'><p><b><i class='fas fa-exclamation-triangle'></i>  Your QR Code does not register</b></p></div>";
   } else {
    // ???
    $stmt2 = sqlCommand("SELECT * FROM tblattendance WHERE fk_student_id = '$emp' AND logdate = $date", $conn);

    if ($stmt2->rowCount() > 0) {
      echo "<div class='alert alert-danger' role='alert'>Student Has No Enrolled Subject at this Hour</div>";
    } else {
      // Collect data of subject base on the student
      $subjects = sqlCommand("SELECT A.time_id, A.duration_id, B.subject_code, A.fk_subject_id
        FROM tbl_student_add_subject AS A
        INNER JOIN tblsubject AS B ON A.fk_subject_id = B.id
        INNER JOIN tblstudentinfo AS C ON A.fk_student_id = C.id
        WHERE C.stud_id = '$emp'", $conn);
      $student_has_no_class = true;

      if ($subjects->rowCount() > 0) {
        while ($result = $subjects->fetch(PDO::FETCH_ASSOC)) {
          $timeInt = timeConvert($result["time_id"]);
          $currTime = timeConvert($time);
          //echo "<div>Check converted and pulled time ".$timeInt." ".$currTime."</div><br/>";

          $durationInt = (int)filter_var($result["duration_id"], FILTER_SANITIZE_NUMBER_INT);

          if ($durationInt != 30 && $durationInt != 130) {
              $durationInt *= 100;
          };
          $endtime = $timeInt + $durationInt;
          // debug
          $cheker = (string)$endtime;
          if ($cheker[-2] == 6) {
            $endtime =+ 100;
            $endtime =- 60;
          }
          $subject_id = $result["fk_subject_id"];


          // Debug
           "<div>Time in:".$timeInt.", End Time:".$endtime.", Duration:".$durationInt.", Current Time:".$currTime.", Subject:".$result["subject_code"]."</div>";

          // check student if they have class
          if ($timeInt <= $currTime && $endtime > $currTime) {
            // there is a chance which student has the lab and lecture in one day and may call it that they login for the subject but in log is not
            $checker = sqlCommand("SELECT time_in FROM tblattendance WHERE fk_student_id='$emp' AND fk_subject_id='$subject_id' AND logdate='$date'", $conn);
            if ($checker->rowCount() > 0) {
              echo "<div class='alert alert-danger' role='alert'>Student has already Log in for the Class</div>";
            } else {
              login($conn, $emp, $time, $date, $subject_id);
            }
            break;
          }
        }
        $student_has_no_class = false;
      }
      
      if ($student_has_no_class) {
        echo "<div class='alert alert-danger' role='alert'>Student has no Matching Class</div>";
      }
    }
  }
}
?>