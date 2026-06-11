<?php
function normalizeDateTimeInput($value) {
    $value = trim((string)$value);
    if ($value === '') {
        return null;
    }

    $value = str_replace('T', ' ', $value);
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $value)) {
        $value .= ':00';
    }

    return $value;
}

function formatDateTimeDisplay($value) {
    if (empty($value)) {
        return 'Any time';
    }

    $timestamp = strtotime($value);
    if (!$timestamp) {
        return htmlspecialchars($value);
    }

    return date('M j, Y g:i A', $timestamp);
}

function examWindowStatus(array $exam) {
    $now = time();
    $start = !empty($exam['start_time']) ? strtotime($exam['start_time']) : null;
    $end = !empty($exam['end_time']) ? strtotime($exam['end_time']) : null;

    if ($start && $now < $start) {
        return [
            'key' => 'upcoming',
            'label' => 'Opens ' . formatDateTimeDisplay($exam['start_time']),
            'open' => false
        ];
    }

    if ($end && $now > $end) {
        return [
            'key' => 'closed',
            'label' => 'Closed',
            'open' => false
        ];
    }

    return [
        'key' => 'open',
        'label' => 'Open',
        'open' => true
    ];
}

function calculateExamDeadline(array $exam) {
    $durationMinutes = max(1, (int)$exam['duration']);
    $deadline = time() + ($durationMinutes * 60);
    $end = !empty($exam['end_time']) ? strtotime($exam['end_time']) : null;

    if ($end && $end < $deadline) {
        $deadline = $end;
    }

    return $deadline;
}

function ensureExamAttemptsTable(mysqli $conn) {
    $conn->query("
        CREATE TABLE IF NOT EXISTS exam_attempts (
            attempt_id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT NOT NULL,
            exam_id INT NOT NULL,
            started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            deadline_at DATETIME NOT NULL,
            submitted_at DATETIME NULL,
            status ENUM('in_progress','submitted','expired') NOT NULL DEFAULT 'in_progress',
            UNIQUE KEY unique_student_exam_attempt (student_id, exam_id),
            FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
            FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE
        )
    ");
}

function getStudentAttempt(mysqli $conn, $studentId, $examId) {
    $stmt = $conn->prepare("SELECT * FROM exam_attempts WHERE student_id=? AND exam_id=? LIMIT 1");
    $stmt->bind_param("ii", $studentId, $examId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function expireAttemptIfNeeded(mysqli $conn, array $attempt) {
    if ($attempt['status'] === 'in_progress' && strtotime($attempt['deadline_at']) < time()) {
        $stmt = $conn->prepare("UPDATE exam_attempts SET status='expired' WHERE attempt_id=?");
        $stmt->bind_param("i", $attempt['attempt_id']);
        $stmt->execute();
        $attempt['status'] = 'expired';
    }

    return $attempt;
}

function redirectWithMessage($url, $messageKey) {
    header("Location: " . $url . (strpos($url, '?') === false ? '?' : '&') . "message=" . urlencode($messageKey));
    exit();
}
?>
