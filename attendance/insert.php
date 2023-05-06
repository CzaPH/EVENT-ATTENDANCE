<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "dbcapstone";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed" . $conn->connect_error);
}

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $date = date('Y-m-d');
    //$time = date('h:i A');
    $time =  date('h:i:A', strtotime("+0 HOURS"));


    $sql3 = "INSERT INTO tblattendance (fk_student_id,time_in,logdate) VALUES ('$student_id','$time','$date')";
    if ($conn->query($sql3) === TRUE) {
        echo "Successfully inserted";
        header("Location: ");
    } else {
        echo "ERROR : " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
