<?php
session_start();
include "../config/db.php";

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') header("Location: ../admin/dashboard.php");
        elseif ($user['role'] == 'lecturer') header("Location: ../lecturer/dashboard.php");
        else header("Location: ../student/dashboard.php");
        exit();
    }
}

header("Location: ../index.php?login=failed#login");
exit();
?>
