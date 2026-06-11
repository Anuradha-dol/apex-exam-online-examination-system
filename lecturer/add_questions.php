<?php
include "../includes/auth_check.php";
checkRole('lecturer');
include "../config/db.php";

$pageTitle = "Add Question | Apex Exam";
$lecturer_id = (int)$_SESSION['user_id'];
$allowedAnswers = ['A', 'B', 'C', 'D'];

if (isset($_POST['add_question'])) {
    $exam_id = (int)($_POST['exam_id'] ?? 0);
    $question_text = trim($_POST['question_text'] ?? '');
    $a = trim($_POST['option_a'] ?? '');
    $b = trim($_POST['option_b'] ?? '');
    $c = trim($_POST['option_c'] ?? '');
    $d = trim($_POST['option_d'] ?? '');
    $correct = $_POST['correct_answer'] ?? '';

    $examCheck = $conn->prepare("
        SELECT e.exam_id
        FROM exams e
        JOIN modules m ON m.module_id=e.module_id
        WHERE e.exam_id=? AND m.lecturer_id=?
        LIMIT 1
    ");
    $examCheck->bind_param("ii", $exam_id, $lecturer_id);
    $examCheck->execute();
    $canUseExam = $examCheck->get_result()->num_rows > 0;

    if ($canUseExam && $question_text !== '' && $a !== '' && $b !== '' && $c !== '' && $d !== '' && in_array($correct, $allowedAnswers, true)) {
        $stmt = $conn->prepare("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("issssss", $exam_id, $question_text, $a, $b, $c, $d, $correct);
        $stmt->execute();

        header("Location: add_questions.php?added=1");
        exit();
    }

    $error = "Please choose one of your exams and complete all question fields.";
}

$examStmt = $conn->prepare("
    SELECT e.exam_id, e.exam_title, m.module_code
    FROM exams e
    JOIN modules m ON m.module_id=e.module_id
    WHERE m.lecturer_id=?
    ORDER BY m.module_code, e.exam_title
");
$examStmt->bind_param("i", $lecturer_id);
$examStmt->execute();
$exams = $examStmt->get_result();
include "../includes/header.php";
?>
<div class="card">
    <h2>Add Question</h2>
    <?php if(isset($_GET['added'])): ?><div class="alert alert-success">Question added successfully.</div><?php endif; ?>
    <?php if(isset($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST" class="form-grid">
        <div class="form-group span-2">
            <label>Exam</label>
            <select name="exam_id" required>
                <option value="">Select Exam</option>
                <?php while($e = $exams->fetch_assoc()): ?>
                    <option value="<?= (int)$e['exam_id'] ?>"><?= htmlspecialchars($e['module_code'] . ' - ' . $e['exam_title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group span-2">
            <label>Question</label>
            <textarea name="question_text" placeholder="Question" required></textarea>
        </div>
        <div class="form-group">
            <label>Option A</label>
            <input type="text" name="option_a" placeholder="Option A" required>
        </div>
        <div class="form-group">
            <label>Option B</label>
            <input type="text" name="option_b" placeholder="Option B" required>
        </div>
        <div class="form-group">
            <label>Option C</label>
            <input type="text" name="option_c" placeholder="Option C" required>
        </div>
        <div class="form-group">
            <label>Option D</label>
            <input type="text" name="option_d" placeholder="Option D" required>
        </div>
        <div class="form-group span-2">
            <label>Correct Answer</label>
            <select name="correct_answer" required>
                <option value="">Correct Answer</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>

        <div class="action-row span-2">
            <button name="add_question">Add Question</button>
            <a href="dashboard.php" class="btn btn-outline">Back</a>
        </div>
    </form>
</div>
<?php include "../includes/footer.php"; ?>
