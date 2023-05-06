<?php
//$conn = new mysqli("localhost", "root", "", "roadshowdb");
$conn = mysqli_connect('lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com','z4lalbkhiykyuwaa','qaxa067j1uqvnx8b','gdcmy2nzpcyi4nxw');


function filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>