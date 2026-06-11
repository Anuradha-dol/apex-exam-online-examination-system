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
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Exam</th><th>Marks</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php while($r = $results->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['exam_title']) ?></td>
                    <td><?= (int)$r['marks'] ?> / <?= (int)$r['total_marks'] ?></td>
                    <td><?= htmlspecialchars($r['submitted_at']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
