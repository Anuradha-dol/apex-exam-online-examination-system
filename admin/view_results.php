<?php
include "../includes/auth_check.php";
checkRole('admin');
include "../config/db.php";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM results WHERE result_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

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
                <tr><th>Student</th><th>Exam</th><th>Marks</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($r = $results->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['student_name']) ?></td>
                    <td><?= htmlspecialchars($r['exam_title']) ?></td>
                    <td><?= (int)$r['marks'] ?> / <?= (int)$r['total_marks'] ?></td>
                    <td><?= htmlspecialchars($r['submitted_at']) ?></td>
                    <td><a class="btn danger" href="?delete=<?= (int)$r['result_id'] ?>" onclick="return confirm('Delete this mark?')">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
