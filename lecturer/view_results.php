<?php
include "../includes/auth_check.php";
checkRole('lecturer');
include "../includes/header.php";
?>
<div class="card">
    <h2>Student Results</h2>
    <div class="toolbar">
        <a href="dashboard.php" class="btn btn-outline">Back</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
