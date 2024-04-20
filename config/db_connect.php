<?php

$servername = "lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "z4lalbkhiykyuwaa";
$password = "uf57bqyv1u9x2cxl";
$database = "gdcmy2nzpcyi4nxw";

try {

	$conn = new PDO("mysql:host=$servername; dbname=$database", $username, $password);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Connection failed:" . $e->getMessage();
}