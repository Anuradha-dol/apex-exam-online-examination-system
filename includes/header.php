<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$basePath = "/online_examination_system";
$showNav = isset($showNav) ? $showNav : true;
$isLanding = !empty($isLanding);
$bodyClass = trim(($bodyClass ?? "") . ($isLanding ? " landing-body" : ""));
$containerClass = $containerClass ?? ($isLanding ? "landing-container" : "container");
$pageTitle = $pageTitle ?? "Apex Exam";
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/style.css">
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
<header class="topbar <?= $isLanding ? 'topbar-landing' : '' ?>">
    <a href="<?= $basePath ?>/index.php" class="brand" aria-label="Apex Exam home">
        <span class="brand-mark">A</span>
        <span><span class="brand-blue">Apex</span><span class="brand-light"> Exam</span></span>
    </a>
    <?php if ($showNav): ?>
        <?php if (isset($_SESSION['name']) && isset($_SESSION['role'])): ?>
            <nav class="topnav">
                <a href="<?= $basePath ?>/<?php echo htmlspecialchars($_SESSION['role']); ?>/dashboard.php">Dashboard</a>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="<?= $basePath ?>/admin/manage_users.php">Users</a>
                    <a href="<?= $basePath ?>/admin/manage_modules.php">Modules</a>
                    <a href="<?= $basePath ?>/admin/manage_exams.php">Exams</a>
                    <a href="<?= $basePath ?>/admin/view_results.php">Results</a>
                <?php elseif ($_SESSION['role'] === 'lecturer'): ?>
                    <a href="<?= $basePath ?>/lecturer/add_questions.php">Add Questions</a>
                    <a href="<?= $basePath ?>/lecturer/manage_questions.php">Questions</a>
                    <a href="<?= $basePath ?>/lecturer/view_results.php">Results</a>
                <?php elseif ($_SESSION['role'] === 'student'): ?>
                    <a href="<?= $basePath ?>/student/exam_list.php">Exams</a>
                    <a href="<?= $basePath ?>/student/my_results.php">My Results</a>
                <?php endif; ?>
            </nav>
        <?php else: ?>
            <nav class="topnav">
                <a href="<?= $basePath ?>/index.php">Home</a>
                <a href="<?= $basePath ?>/index.php#about">About</a>
                <a href="<?= $basePath ?>/index.php#features">Features</a>
                <a href="<?= $basePath ?>/index.php#workflow">How It Works</a>
                <a href="<?= $basePath ?>/index.php#login">Login</a>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
    <div class="topbar-actions">
        <?php if(isset($_SESSION['name'])): ?>
            <span>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="<?= $basePath ?>/auth/logout.php" class="btn danger">Logout</a>
        <?php elseif ($isLanding): ?>
            <a href="<?= $basePath ?>/index.php#login" class="btn btn-ghost">Login</a>
            <a href="<?= $basePath ?>/auth/register.php" class="btn btn-sm">Sign Up</a>
        <?php endif; ?>
    </div>
 </header>
<main class="<?= htmlspecialchars($containerClass) ?>">
