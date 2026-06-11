<?php
include "../includes/auth_check.php";
checkRole('student');
include "../config/db.php";
include "../includes/exam_helpers.php";

$student_id = $_SESSION['user_id'];
ensureExamAttemptsTable($conn);

$stmt = $conn->prepare("
SELECT e.*, m.module_name, r.result_id, a.attempt_id, a.status AS attempt_status, a.deadline_at
FROM exams e
JOIN modules m ON e.module_id=m.module_id
LEFT JOIN results r ON r.exam_id=e.exam_id AND r.student_id=?
LEFT JOIN exam_attempts a ON a.exam_id=e.exam_id AND a.student_id=?
ORDER BY e.exam_id DESC
");
$stmt->bind_param("ii", $student_id, $student_id);
$stmt->execute();
$exams = $stmt->get_result();
include "../includes/header.php";
?>
<div class="card">
    <h2>Available Exams</h2>
    <p class="form-note">Open assessments assigned to you are listed below. Start only when you are ready and have reviewed the exam instructions.</p>
    <?php if (isset($_GET['message'])): ?>
        <?php
        $messages = [
            'not_found' => ['alert-danger', 'Exam not found.'],
            'already_attempted' => ['alert-info', 'You have already submitted this exam.'],
            'not_open' => ['alert-warning', 'This exam is not open for participation right now.'],
            'expired' => ['alert-danger', 'Your exam time has expired.'],
            'no_questions' => ['alert-warning', 'This exam has no questions yet.']
        ];
        $message = $messages[$_GET['message']] ?? ['alert-info', 'Exam status updated.'];
        ?>
        <div class="alert <?= $message[0] ?>"><?= htmlspecialchars($message[1]) ?></div>
    <?php endif; ?>
    <div class="toolbar">
        <a href="dashboard.php" class="btn btn-outline">Back</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Exam</th><th>Module</th><th>Window</th><th>Duration</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($e = $exams->fetch_assoc()): ?>
                    <?php
                    $status = examWindowStatus($e);
                    $attemptStatus = $e['attempt_status'];
                    if ($attemptStatus === 'in_progress' && !empty($e['deadline_at']) && strtotime($e['deadline_at']) < time()) {
                        $attemptStatus = 'expired';
                        $update = $conn->prepare("UPDATE exam_attempts SET status='expired' WHERE attempt_id=?");
                        $update->bind_param("i", $e['attempt_id']);
                        $update->execute();
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($e['exam_title']) ?></td>
                        <td><?= htmlspecialchars($e['module_name']) ?></td>
                        <td>
                            <?= formatDateTimeDisplay($e['start_time']) ?><br>
                            <span class="form-note">to <?= formatDateTimeDisplay($e['end_time']) ?></span>
                        </td>
                        <td><?= (int)$e['duration'] ?> min</td>
                        <td>
                            <?php if ($e['result_id']): ?>
                                <span class="status-pill status-submitted">Submitted</span>
                            <?php elseif ($attemptStatus === 'expired'): ?>
                                <span class="status-pill status-expired">Expired</span>
                            <?php elseif ($attemptStatus === 'in_progress'): ?>
                                <span class="status-pill status-open">In Progress</span>
                            <?php else: ?>
                                <span class="status-pill status-<?= htmlspecialchars($status['key']) ?>"><?= htmlspecialchars($status['label']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($e['result_id']): ?>
                                <a class="btn btn-outline" href="result.php?exam_id=<?= (int)$e['exam_id'] ?>">View Result</a>
                            <?php elseif ($attemptStatus === 'expired'): ?>
                                <span class="status-pill status-expired">Closed</span>
                            <?php elseif ($attemptStatus === 'in_progress'): ?>
                                <a class="btn success" href="start_exam.php?exam_id=<?= (int)$e['exam_id'] ?>">Resume</a>
                            <?php elseif ($status['open']): ?>
                                <a class="btn success" href="start_exam.php?exam_id=<?= (int)$e['exam_id'] ?>">Start</a>
                            <?php else: ?>
                                <span class="status-pill status-neutral">Unavailable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
