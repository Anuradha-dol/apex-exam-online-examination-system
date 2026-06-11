<?php
include "../includes/auth_check.php";
checkRole('lecturer');
$pageTitle = "Lecturer Dashboard | Apex Exam";
include "../includes/header.php";
?>
<div class="dashboard-page">
    <section class="dashboard-hero">
        <div>
            <span class="eyebrow">Lecturer Dashboard</span>
            <h1>Build assessments and guide exam delivery with confidence.</h1>
            <p>Create exam questions, add student instructions, and review performance from one polished workspace.</p>
        </div>
    </section>

    <section class="dashboard-grid">
        <a class="dashboard-card" href="add_questions.php">
            <h3>Add Questions</h3>
            <p>Create new exam questions and build assessments in minutes.</p>
        </a>
        <a class="dashboard-card" href="manage_questions.php">
            <h3>Manage Questions</h3>
            <p>Edit and organize your question library for upcoming exams.</p>
        </a>
        <a class="dashboard-card" href="view_results.php">
            <h3>View Results</h3>
            <p>Review student performance and track exam outcomes easily.</p>
        </a>
    </section>
</div>
<?php include "../includes/footer.php"; ?>
