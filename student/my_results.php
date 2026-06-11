<?php
include "../includes/auth_check.php";
checkRole('student');
include "../includes/header.php";
?>
<div class="card">
    <h2>My Results</h2>
    <div class="toolbar">
        <a href="dashboard.php" class="btn btn-outline">Back</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
