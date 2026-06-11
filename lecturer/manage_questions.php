<?php
include "../includes/auth_check.php";
checkRole('lecturer');
include "../config/db.php";

$pageTitle = "Manage Questions | Apex Exam";
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM questions WHERE question_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$questions = $conn->query("
SELECT q.*, e.exam_title 
FROM questions q 
JOIN exams e ON q.exam_id=e.exam_id 
ORDER BY q.question_id DESC
");
include "../includes/header.php";
?>
<div class="card">
    <h2>Manage Questions</h2>
    <div class="toolbar">
        <a href="dashboard.php" class="btn btn-outline">Back</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Exam</th><th>Question</th><th>Correct</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($q = $questions->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($q['exam_title']) ?></td>
                    <td><?= htmlspecialchars($q['question_text']) ?></td>
                    <td><span class="status-pill status-neutral"><?= htmlspecialchars($q['correct_answer']) ?></span></td>
                    <td><a class="btn danger" href="?delete=<?= (int)$q['question_id'] ?>" onclick="return confirm('Delete question?')">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
