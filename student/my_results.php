<?php
include "../includes/auth_check.php";
checkRole('student');
include "../config/db.php";

$student_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
SELECT r.*, e.exam_title
FROM results r
JOIN exams e ON r.exam_id=e.exam_id
WHERE r.student_id=?
ORDER BY r.submitted_at DESC
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$results = $stmt->get_result();

include "../includes/header.php";
?>
<div class="card">
    <h2>My Results</h2>
    <p class="form-note">Review your completed exams and compare marks to your overall exam performance.</p>
    <div class="toolbar">
        <a href="dashboard.php" class="btn btn-outline">Back</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
