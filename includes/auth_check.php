<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/base_path.php";

function checkRole($role) {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $role) {
        header("Location: " . appBasePath() . "/index.php");
        exit();
    }
}
?>
