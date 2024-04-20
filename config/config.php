<?php
//$conn = new mysqli("localhost", "root", "", "roadshowdb");
$conn = mysqli_connect('lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com','z4lalbkhiykyuwaa','uf57bqyv1u9x2cxl','gdcmy2nzpcyi4nxw');


function filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>