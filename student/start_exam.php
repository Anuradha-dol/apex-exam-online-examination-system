<?php
include "../includes/auth_check.php";
checkRole('student');
include "../config/db.php";
include "../includes/exam_helpers.php";

$student_id = $_SESSION['user_id'];
$exam_id = filter_input(INPUT_GET, 'exam_id', FILTER_VALIDATE_INT);
if (!$exam_id) {
    redirectWithMessage("exam_list.php", "not_found");
}

ensureExamAttemptsTable($conn);

$stmt = $conn->prepare("
SELECT e.*, m.module_name
FROM exams e
JOIN modules m ON m.module_id=e.module_id
WHERE e.exam_id=?
");
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$exam = $stmt->get_result()->fetch_assoc();

if (!$exam) {
    redirectWithMessage("exam_list.php", "not_found");
}

$resultCheck = $conn->prepare("SELECT result_id FROM results WHERE student_id=? AND exam_id=? LIMIT 1");
$resultCheck->bind_param("ii", $student_id, $exam_id);
$resultCheck->execute();
if ($resultCheck->get_result()->num_rows > 0) {
    redirectWithMessage("exam_list.php", "already_attempted");
}

$status = examWindowStatus($exam);
if (!$status['open']) {
    redirectWithMessage("exam_list.php", "not_open");
}

$questionCountStmt = $conn->prepare("SELECT COUNT(*) AS total FROM questions WHERE exam_id=?");
$questionCountStmt->bind_param("i", $exam_id);
$questionCountStmt->execute();
$questionCount = (int)$questionCountStmt->get_result()->fetch_assoc()['total'];
if ($questionCount === 0) {
    redirectWithMessage("exam_list.php", "no_questions");
}

$attempt = getStudentAttempt($conn, $student_id, $exam_id);
if ($attempt) {
    $attempt = expireAttemptIfNeeded($conn, $attempt);
    if ($attempt['status'] === 'submitted') {
        redirectWithMessage("exam_list.php", "already_attempted");
    }
    if ($attempt['status'] === 'expired') {
        redirectWithMessage("exam_list.php", "expired");
    }
    $deadlineAt = $attempt['deadline_at'];
} else {
    $deadlineTimestamp = calculateExamDeadline($exam);
    if ($deadlineTimestamp <= time()) {
        redirectWithMessage("exam_list.php", "expired");
    }
    $deadlineAt = date('Y-m-d H:i:s', $deadlineTimestamp);
    $insertAttempt = $conn->prepare("INSERT INTO exam_attempts (student_id, exam_id, deadline_at) VALUES (?, ?, ?)");
    $insertAttempt->bind_param("iis", $student_id, $exam_id, $deadlineAt);
    $insertAttempt->execute();
    $attempt = getStudentAttempt($conn, $student_id, $exam_id);
}

$remainingSeconds = max(0, strtotime($deadlineAt) - time());
if ($remainingSeconds <= 0) {
    $attempt = expireAttemptIfNeeded($conn, $attempt);
    redirectWithMessage("exam_list.php", "expired");
}

$qstmt = $conn->prepare("SELECT * FROM questions WHERE exam_id=?");
$qstmt->bind_param("i", $exam_id);
$qstmt->execute();
$questions = $qstmt->get_result();

include "../includes/header.php";
?>
<script src="../assets/js/timer.js"></script>
<div class="exam-layout">
    <section class="exam-main">
        <div>
            <span class="eyebrow"><?= htmlspecialchars($exam['module_name']) ?></span>
            <h1><?= htmlspecialchars($exam['exam_title']) ?></h1>
            <p class="form-note">Please read all instructions carefully before submitting. Unanswered questions are counted in the total.</p>
        </div>

        <?php if (!empty($exam['exam_instructions'])): ?>
            <div class="instruction-panel">
                <h3>Exam Instructions</h3>
                <p><?= nl2br(htmlspecialchars($exam['exam_instructions'])) ?></p>
            </div>
        <?php endif; ?>

        <form id="examForm" action="submit_exam.php" method="POST">
            <input type="hidden" name="exam_id" value="<?= (int)$exam_id ?>">
            <input type="hidden" name="attempt_id" value="<?= (int)$attempt['attempt_id'] ?>">
            <input type="hidden" name="auto_submit" value="0">

            <div class="form-group checkbox-group">
                <label class="checkbox-label"><input type="checkbox" name="agree_rules" required> I have read the instructions and agree to complete this exam responsibly.</label>
            </div>

            <?php $i=1; while($q = $questions->fetch_assoc()): ?>
                <article class="question-card">
                    <h3>Question <?= $i++ ?></h3>
                    <p><?= htmlspecialchars($q['question_text']) ?></p>

                    <div class="answer-list">
                        <label class="answer-option"><input type="radio" name="answer[<?= (int)$q['question_id'] ?>]" value="A"> <span>A. <?= htmlspecialchars($q['option_a']) ?></span></label>
                        <label class="answer-option"><input type="radio" name="answer[<?= (int)$q['question_id'] ?>]" value="B"> <span>B. <?= htmlspecialchars($q['option_b']) ?></span></label>
                        <label class="answer-option"><input type="radio" name="answer[<?= (int)$q['question_id'] ?>]" value="C"> <span>C. <?= htmlspecialchars($q['option_c']) ?></span></label>
                        <label class="answer-option"><input type="radio" name="answer[<?= (int)$q['question_id'] ?>]" value="D"> <span>D. <?= htmlspecialchars($q['option_d']) ?></span></label>
                    </div>
                </article>
            <?php endwhile; ?>

            <button type="submit" class="success">Submit Exam</button>
        </form>
    </section>
    <aside class="exam-side">
        <div class="timer-label">Time Remaining</div>
        <div id="timer" class="timer"></div>
        <p class="form-note">Deadline: <?= formatDateTimeDisplay($deadlineAt) ?></p>
    </aside>
</div>
<script>
startTimer(<?= (int)$remainingSeconds ?>);
</script>
<?php include "../includes/footer.php"; ?>
