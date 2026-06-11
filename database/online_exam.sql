CREATE DATABASE IF NOT EXISTS online_exam_db;
USE online_exam_db;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','lecturer','student') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE modules (
    module_id INT AUTO_INCREMENT PRIMARY KEY,
    module_code VARCHAR(50) NOT NULL,
    module_name VARCHAR(150) NOT NULL,
    lecturer_id INT,
    FOREIGN KEY (lecturer_id) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE exams (
    exam_id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT NOT NULL,
    exam_title VARCHAR(150) NOT NULL,
    exam_instructions TEXT NULL,
    duration INT NOT NULL,
    start_time DATETIME NULL,
    end_time DATETIME NULL,
    created_by INT,
    FOREIGN KEY (module_id) REFERENCES modules(module_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    exam_id INT NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_answer ENUM('A','B','C','D') NOT NULL,
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE
);

CREATE TABLE student_answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    question_id INT NOT NULL,
    selected_answer ENUM('A','B','C','D') NOT NULL,
    UNIQUE KEY unique_student_exam_question (student_id, exam_id, question_id),
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
);

CREATE TABLE exam_attempts (
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
);

CREATE TABLE results (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    marks INT NOT NULL,
    total_marks INT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_student_exam (student_id, exam_id),
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@gmail.com', '$2y$10$76ZWjzmG..2.xaCuqeW8AOI2mV5mBMBCrtjDLEwQR8DIQ5MgdcjgS', 'admin'),
('Lecturer User', 'lecturer@gmail.com', '$2y$10$76ZWjzmG..2.xaCuqeW8AOI2mV5mBMBCrtjDLEwQR8DIQ5MgdcjgS', 'lecturer'),
('Student User', 'student@gmail.com', '$2y$10$76ZWjzmG..2.xaCuqeW8AOI2mV5mBMBCrtjDLEwQR8DIQ5MgdcjgS', 'student');

-- Default password for all sample accounts: 123456
