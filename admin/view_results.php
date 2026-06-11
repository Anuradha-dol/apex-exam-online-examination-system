<?php
include "../includes/auth_check.php";
checkRole('admin');
include "../config/db.php";

$results = $conn->query("
SELECT r.*, s.name AS student_name, e.exam_title
FROM results r
JOIN users s ON r.student_id=s.user_id
JOIN exams e ON r.exam_id=e.exam_id
ORDER BY r.submitted_at DESC
");
include "../includes/header.php";
?>
<div class="card">
    <h2>All Results</h2>
    <div class="toolbar">
        <a href="dashboard.php" class="btn btn-outline">Back</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Student</th><th>Exam</th><th>Marks</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php while($r = $results->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['student_name']) ?></td>
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
