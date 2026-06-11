<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkRole($role) {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $role) {
        header("Location: /online_examination_system/index.php");
        exit();
    }
}
?>
