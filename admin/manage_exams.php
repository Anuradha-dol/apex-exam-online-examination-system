<?php
include "../includes/auth_check.php";
checkRole('admin');
include "../config/db.php";
include "../includes/exam_helpers.php";

$pageTitle = "Manage Exams | Apex Exam";
$columnCheck = $conn->query("SHOW COLUMNS FROM exams LIKE 'exam_instructions'");
if ($columnCheck && $columnCheck->num_rows === 0) {
    $conn->query("ALTER TABLE exams ADD COLUMN exam_instructions TEXT NULL");
}

if (isset($_POST['add_exam'])) {
    $module_id = (int)$_POST['module_id'];
    $exam_title = trim($_POST['exam_title']);
    $duration = max(1, (int)$_POST['duration']);
    $start_time = normalizeDateTimeInput($_POST['start_time'] ?? '');
    $end_time = normalizeDateTimeInput($_POST['end_time'] ?? '');
    $exam_instructions = trim($_POST['exam_instructions'] ?? '');
    $created_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO exams (module_id, exam_title, duration, start_time, end_time, created_by, exam_instructions) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("isissis", $module_id, $exam_title, $duration, $start_time, $end_time, $created_by, $exam_instructions);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM exams WHERE exam_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$modules = $conn->query("SELECT * FROM modules");
$exams = $conn->query("SELECT e.*, m.module_name FROM exams e JOIN modules m ON e.module_id=m.module_id ORDER BY e.exam_id DESC");
include "../includes/header.php";
?>
<div class="card">
    <h2>Manage Exams</h2>
    <form method="POST" class="form-grid">
        <div class="form-group">
            <label>Module</label>
            <select name="module_id" required>
                <option value="">Select Module</option>
                <?php while($m = $modules->fetch_assoc()): ?>
                    <option value="<?= (int)$m['module_id'] ?>"><?= htmlspecialchars($m['module_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Exam Title</label>
            <input type="text" name="exam_title" placeholder="Midterm MCQ Exam" required>
        </div>
        <div class="form-group span-2">
            <label>Instructions</label>
            <textarea name="exam_instructions" placeholder="Exam instructions and rules for students" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label>Duration in minutes</label>
            <input type="number" name="duration" min="1" placeholder="60" required>
        </div>
        <div class="form-group">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time">
        </div>
        <div class="form-group">
            <label>End Time</label>
            <input type="datetime-local" name="end_time">
        </div>
        <div class="action-row span-2">
            <button name="add_exam">Add Exam</button>
            <a href="dashboard.php" class="btn btn-outline">Back</a>
        </div>
    </form>

    <div class="table-wrap mt-4">
        <table>
            <thead>
                <tr><th>Exam</th><th>Module</th><th>Window</th><th>Duration</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($e = $exams->fetch_assoc()): ?>
                    <?php $status = examWindowStatus($e); ?>
                    <tr>
                        <td><?= htmlspecialchars($e['exam_title']) ?></td>
                        <td><?= htmlspecialchars($e['module_name']) ?></td>
                        <td><?= formatDateTimeDisplay($e['start_time']) ?> to <?= formatDateTimeDisplay($e['end_time']) ?></td>
                        <td><?= (int)$e['duration'] ?> min</td>
                        <td><span class="status-pill status-<?= htmlspecialchars($status['key']) ?>"><?= htmlspecialchars($status['label']) ?></span></td>
                        <td><a class="btn danger" href="?delete=<?= (int)$e['exam_id'] ?>" onclick="return confirm('Delete exam?')">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
