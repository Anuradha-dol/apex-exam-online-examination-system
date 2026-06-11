<?php
include "../includes/auth_check.php";
checkRole('admin');
include "../includes/header.php";
?>
<div class="dashboard-page">
    <section class="dashboard-hero">
        <div>
            <span class="eyebrow">Admin Dashboard</span>
            <h1>Oversee exam operations with clarity and efficiency.</h1>
            <p>Manage users, modules, and exams from one secure control panel for your institution.</p>
        </div>
    </section>

    <section class="dashboard-grid dashboard-grid-4">
        <a class="dashboard-card" href="manage_users.php">
            <h3>Manage Users</h3>
            <p>Create and update student, lecturer, and admin accounts.</p>
        </a>
        <a class="dashboard-card" href="manage_modules.php">
            <h3>Manage Modules</h3>
            <p>Assign lecturers and keep module data organized.</p>
        </a>
        <a class="dashboard-card" href="manage_exams.php">
            <h3>Manage Exams</h3>
            <p>Configure upcoming exams, dates, and exam settings.</p>
        </a>
        <a class="dashboard-card" href="view_results.php">
            <h3>View Results</h3>
            <p>Track overall exam performance across students and modules.</p>
        </a>
    </section>
</div>
<?php include "../includes/footer.php"; ?>
