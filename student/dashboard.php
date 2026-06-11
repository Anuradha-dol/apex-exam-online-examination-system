<?php
include "../includes/auth_check.php";
checkRole('student');
include "../includes/header.php";
?>
<div class="dashboard-page">
    <section class="dashboard-hero">
        <div>
            <span class="eyebrow">Student Dashboard</span>
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['name']) ?></h1>
            <p>Your ApexExam portal is ready. Start assigned exams, review results, and keep your progress on track.</p>
        </div>
    </section>

    <section class="dashboard-grid">
        <a class="dashboard-card" href="exam_list.php">
            <h3>Available Exams</h3>
            <p>Browse exams ready for you to start and track your progress instantly.</p>
        </a>
        <a class="dashboard-card" href="my_results.php">
            <h3>My Results</h3>
            <p>Review your exam results and performance history in one place.</p>
        </a>
    </section>
</div>
<?php include "../includes/footer.php"; ?>
