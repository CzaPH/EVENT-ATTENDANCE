<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//$conn = new mysqli("localhost", "root", "", "roadshowdb");
// $conn = new mysqli("localhost", "root", "", "dbcapstone");
$conn = new mysqli("lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "z4lalbkhiykyuwaa", "qaxa067j1uqvnx8b", "gdcmy2nzpcyi4nxw");
if ($conn->connect_error) {
    exit('Error connecting to database'); //Should be a message a typical user could understand in production
}
?>