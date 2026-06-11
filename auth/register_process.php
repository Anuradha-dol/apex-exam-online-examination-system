<?php
include "../config/db.php";

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$plainPassword = $_POST['password'] ?? '';
if (!isset($_POST['terms'])) {
    header("Location: register.php?error=terms");
    exit();
}

if ($name === '' || $email === '' || $plainPassword === '') {
    header("Location: register.php?error=missing");
    exit();
}

$password = password_hash($plainPassword, PASSWORD_DEFAULT);
$role = 'student';

$sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    header("Location: ../index.php?registered=1#login");
    exit;
} else {
    header("Location: register.php?error=email");
    exit();
}
?>
