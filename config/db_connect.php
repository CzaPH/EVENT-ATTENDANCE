<?php

$servername = "lfmerukkeiac5y5w.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "z4lalbkhiykyuwaa";
$password = "qaxa067j1uqvnx8b";
$database = "roadshowdb";

try {

	$conn = new PDO("mysql:host=$servername; dbname=$database", $username, $password);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Connection failed:" . $e->getMessage();
}