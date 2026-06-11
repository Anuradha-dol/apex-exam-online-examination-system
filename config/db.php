<?php
date_default_timezone_set('Asia/Colombo');

$host = "localhost";
$user = "root";
$pass = "Anu@20021214"; 
$dbname = "online_exam_db";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
$conn->query("SET time_zone = '+05:30'");
?>
