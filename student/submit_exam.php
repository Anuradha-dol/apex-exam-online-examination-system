<?php
include "../includes/auth_check.php";
checkRole('student');
include "../config/db.php";
include "../includes/exam_helpers.php";

$student_id = $_SESSION['user_id'];
$exam_id = filter_input(INPUT_POST, 'exam_id', FILTER_VALIDATE_INT);
$attempt_id = filter_input(INPUT_POST, 'attempt_id', FILTER_VALIDATE_INT);
$answers = $_POST['answer'] ?? [];

if (!$exam_id || !$attempt_id) {
    redirectWithMessage("exam_list.php", "not_found");
}

ensureExamAttemptsTable($conn);

$examStmt = $conn->prepare("SELECT * FROM exams WHERE exam_id=?");
$examStmt->bind_param("i", $exam_id);
$examStmt->execute();
$exam = $examStmt->get_result()->fetch_assoc();
if (!$exam) {
    redirectWithMessage("exam_list.php", "not_found");
}

$attemptStmt = $conn->prepare("SELECT * FROM exam_attempts WHERE attempt_id=? AND student_id=? AND exam_id=? LIMIT 1");
$attemptStmt->bind_param("iii", $attempt_id, $student_id, $exam_id);
$attemptStmt->execute();
$attempt = $attemptStmt->get_result()->fetch_assoc();
if (!$attempt || $attempt['status'] !== 'in_progress') {
    redirectWithMessage("exam_list.php", "already_attempted");
}

$graceSeconds = 30;
if (strtotime($attempt['deadline_at']) + $graceSeconds < time()) {
    $expire = $conn->prepare("UPDATE exam_attempts SET status='expired' WHERE attempt_id=?");
    $expire->bind_param("i", $attempt_id);
    $expire->execute();
    redirectWithMessage("exam_list.php", "expired");
}

$resultCheck = $conn->prepare("SELECT result_id FROM results WHERE student_id=? AND exam_id=? LIMIT 1");
$resultCheck->bind_param("ii", $student_id, $exam_id);
$resultCheck->execute();
if ($resultCheck->get_result()->num_rows > 0) {
    redirectWithMessage("exam_list.php", "already_attempted");
}

$questionStmt = $conn->prepare("SELECT question_id, correct_answer FROM questions WHERE exam_id=?");
$questionStmt->bind_param("i", $exam_id);
$questionStmt->execute();
$questionResult = $questionStmt->get_result();

$questions = [];
while ($row = $questionResult->fetch_assoc()) {
    $questions[(int)$row['question_id']] = $row['correct_answer'];
}

$marks = 0;
$total = count($questions);
$allowedAnswers = ['A', 'B', 'C', 'D'];

$conn->begin_transaction();

try {
    foreach ($answers as $question_id => $selected) {
        $question_id = (int)$question_id;
        $selected = strtoupper(trim((string)$selected));

        if (!isset($questions[$question_id]) || !in_array($selected, $allowedAnswers, true)) {
            continue;
        }

        if ($selected === $questions[$question_id]) {
            $marks++;
        }

        $insert = $conn->prepare("
            INSERT INTO student_answers (student_id, exam_id, question_id, selected_answer)
            VALUES (?,?,?,?)
        ");
        $insert->bind_param("iiis", $student_id, $exam_id, $question_id, $selected);
        $insert->execute();
    }

    $res = $conn->prepare("INSERT INTO results (student_id, exam_id, marks, total_marks) VALUES (?,?,?,?)");
    $res->bind_param("iiii", $student_id, $exam_id, $marks, $total);
    $res->execute();

    $submittedAt = date('Y-m-d H:i:s');
    $attemptUpdate = $conn->prepare("UPDATE exam_attempts SET status='submitted', submitted_at=? WHERE attempt_id=?");
    $attemptUpdate->bind_param("si", $submittedAt, $attempt_id);
    $attemptUpdate->execute();

    $conn->commit();
} catch (Throwable $e) {
    $conn->rollback();
    redirectWithMessage("exam_list.php", "already_attempted");
}

header("Location: result.php?exam_id=$exam_id");
exit();
?>
