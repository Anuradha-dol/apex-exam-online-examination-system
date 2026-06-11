<?php
include "../includes/auth_check.php";
checkRole('lecturer');
include "../config/db.php";

if (isset($_POST['add_question'])) {
    $exam_id = $_POST['exam_id'];
    $question_text = $_POST['question_text'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $correct = $_POST['correct_answer'];

    $stmt = $conn->prepare("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("issssss", $exam_id, $question_text, $a, $b, $c, $d, $correct);
    $stmt->execute();
    $msg = "Question added successfully.";
}

$exams = $conn->query("SELECT * FROM exams");
include "../includes/header.php";
?>
<div class="card">
    <h2>Add Question</h2>
    <?php if(isset($msg)): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST" class="form-grid">
        <div class="form-group span-2">
            <label>Exam</label>
            <select name="exam_id" required>
                <option value="">Select Exam</option>
                <?php while($e = $exams->fetch_assoc()): ?>
                    <option value="<?= (int)$e['exam_id'] ?>"><?= htmlspecialchars($e['exam_title']) ?></option>
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
