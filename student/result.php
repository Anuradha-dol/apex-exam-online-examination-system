<?php
include "../includes/auth_check.php";
checkRole('student');
include "../config/db.php";

$student_id = $_SESSION['user_id'];
$exam_id = $_GET['exam_id'];

$stmt = $conn->prepare("
SELECT r.*, e.exam_title 
FROM results r 
JOIN exams e ON r.exam_id=e.exam_id 
WHERE r.student_id=? AND r.exam_id=?
");
$stmt->bind_param("ii", $student_id, $exam_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    header("Location: exam_list.php");
    exit();
}

include "../includes/header.php";
?>
<div class="card">
    <h2>Exam Performance</h2>
</div>
<?php include "../includes/footer.php"; ?>
