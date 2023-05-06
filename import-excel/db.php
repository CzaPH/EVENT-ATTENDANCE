<?php
// $conn=mysqli_connect("localhost","root","","dbcapstone") or die("Could not connect");
$conn = mysqli_connect("lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "z4lalbkhiykyuwaa", "qaxa067j1uqvnx8b", "gdcmy2nzpcyi4nxw")
 or die("Could not connect");

mysqli_select_db($conn,"gdcmy2nzpcyi4nxw") or die("could not connect database");
?>