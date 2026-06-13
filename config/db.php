<?php
date_default_timezone_set('Asia/Colombo');

$dbConfig = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "dbname" => "online_exam_db",
    "port" => 3306,
];

$localConfigPath = __DIR__ . "/db.local.php";
if (file_exists($localConfigPath)) {
    $localConfig = require $localConfigPath;
    if (is_array($localConfig)) {
        $dbConfig = array_merge($dbConfig, $localConfig);
    }
}

$conn = new mysqli(
    $dbConfig["host"],
    $dbConfig["user"],
    $dbConfig["pass"],
    $dbConfig["dbname"],
    (int)$dbConfig["port"]
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
$conn->query("SET time_zone = '+05:30'");
?>
