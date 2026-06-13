# Apex Exam - Online Examination System

Apex Exam is a web-based online examination system built with PHP and MySQL. It provides separate dashboards for admins, lecturers, and students, allowing an educational institute to manage users, modules, exams, MCQ questions, timed exam attempts, and exam results from one application.

The project is designed for a local XAMPP/WAMP-style PHP environment and does not require a PHP framework, Composer package installation, or a frontend build step.

## Table of Contents

- [Project Overview](#project-overview)
- [Technology Stack](#technology-stack)
- [Main Features](#main-features)
- [User Roles and Permissions](#user-roles-and-permissions)
- [Team Members and Contributions](#team-members-and-contributions)
- [Database Structure](#database-structure)
- [Project Structure](#project-structure)
- [Installation and Setup](#installation-and-setup)
- [Default Login Accounts](#default-login-accounts)
- [Application Workflow](#application-workflow)
- [Security and Validation Notes](#security-and-validation-notes)

## Project Overview

Apex Exam supports the complete basic online exam process:

1. Admins create users, modules, and scheduled exams.
2. Lecturers add MCQ questions to exams assigned to their modules.
3. Students view available exams, start an exam during the allowed time window, answer questions, and submit the paper.
4. The system calculates marks immediately and stores the result.
5. Admins, lecturers, and students can view result records based on their dashboard access.

## Project Report

A detailed project overview report with UI screenshots, system functions, project workflow, and team member contributions is available here:

[View Apex Exam Project Overview Report](ApexExam_Project_Overview_Report_FIXED.pdf)

## Technology Stack

| Layer | Technology |
| --- | --- |
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Local Server | XAMPP, WAMP, MAMP, or any PHP/MySQL server |
| Database Tool | phpMyAdmin or MySQL client |
| Styling Assets | Custom CSS, SVG/PNG images |

## Main Features

### Authentication and Access Control

- Login with email and password.
- Student registration with terms confirmation.
- Secure password hashing using PHP `password_hash()`.
- Password verification using PHP `password_verify()`.
- Session-based authentication.
- Role-based dashboard redirection.
- Protected admin, lecturer, and student pages.
- Logout functionality.

### Admin Dashboard

- Manage users.
- Create admin, lecturer, and student accounts.
- Delete user accounts.
- Manage academic modules.
- Assign lecturers to modules.
- Create exams for modules.
- Add exam title, instructions, duration, start time, and end time.
- View exam availability status.
- Delete exams.
- View and delete result records.

### Lecturer Dashboard

- View lecturer dashboard.
- Add MCQ questions to exams connected to the lecturer's assigned modules.
- Add four answer options for each question.
- Select the correct answer from A, B, C, or D.
- View existing questions.
- Delete questions owned through assigned modules.
- View student result records.

### Student Dashboard

- View available exams.
- See exam module, time window, duration, and current status.
- Start exams only during the allowed availability window.
- Resume an in-progress exam before the deadline.
- Read exam instructions before answering.
- Answer MCQ questions.
- Submit exams manually.
- Auto-submit exams when the countdown timer reaches zero.
- View instant marks after submission.
- View personal result history.

### Exam Attempt Control

- Single attempt per student per exam.
- Attempt records are stored in the `exam_attempts` table.
- Duplicate submissions are blocked.
- Expired attempts are marked as expired.
- Server-side deadline validation is applied during submission.
- Exam deadline is calculated from the exam duration and the configured exam end time.

### Result Handling

- Marks are calculated by comparing selected answers with stored correct answers.
- Unanswered questions are included in the total mark count.
- Student answers are stored in `student_answers`.
- Final marks are stored in `results`.
- Students can view only their own results.
- Admin and lecturer dashboards include result listing pages.

### User Interface

- Landing page with project introduction and login form.
- Responsive dashboards for each user role.
- Tables for users, modules, exams, questions, and results.
- Status labels for open, upcoming, closed, submitted, expired, and in-progress exams.
- Timer warning states for exams close to deadline.

## User Roles and Permissions

| Role | Main Responsibilities | Available Functions |
| --- | --- | --- |
| Admin | Controls core system data and exam setup. | Manage users, manage modules, assign lecturers, create exams, configure exam windows, view/delete results. |
| Lecturer | Builds and reviews exam content. | Add MCQ questions, manage questions for assigned modules, view result records. |
| Student | Participates in exams. | Register, log in, view available exams, start/resume exams, submit answers, view own results. |

## Team Members and Contributions

| Member | Main Area | Contribution |
| --- | --- | --- |
| Anuradha | Smart Student Examination System | Student exam flow, available exam listing, exam start/resume behavior, countdown timer, auto-submit flow, single-attempt handling, instant result display. |
| Damsi | Result Analytics and Reporting | Result viewing, student result history, admin/lecturer result records, marks display, result management pages. |
| Supuni | Authentication and User Management | Login, registration, logout, session handling, role-based access control, user creation and user management. |
| Pabasha | Module and Exam Management | Module CRUD, lecturer assignment, exam creation, exam schedule, duration setup, exam instructions, and exam management pages. |

## Database Structure

The database file is located at:

```text
database/online_exam.sql
```

The SQL file creates the database:

```text
online_exam_db
```

Main database tables:

| Table | Purpose |
| --- | --- |
| `users` | Stores admin, lecturer, and student accounts. |
| `modules` | Stores academic module information and assigned lecturer. |
| `exams` | Stores exam details, duration, instructions, and availability window. |
| `questions` | Stores MCQ questions, options, and correct answers. |
| `student_answers` | Stores selected answers submitted by students. |
| `exam_attempts` | Tracks started, submitted, and expired student exam attempts. |
| `results` | Stores final marks for completed exams. |

## Project Structure

```text
apex-exam-online-examination-system/
|-- admin/
|   |-- dashboard.php
|   |-- manage_exams.php
|   |-- manage_modules.php
|   |-- manage_users.php
|   `-- view_results.php
|-- assets/
|   |-- css/
|   |   `-- style.css
|   |-- images/
|   `-- js/
|       `-- timer.js
|-- auth/
|   |-- login_process.php
|   |-- logout.php
|   |-- register.php
|   `-- register_process.php
|-- config/
|   `-- db.php
|-- database/
|   `-- online_exam.sql
|-- includes/
|   |-- auth_check.php
|   |-- base_path.php
|   |-- exam_helpers.php
|   |-- footer.php
|   `-- header.php
|-- lecturer/
|   |-- add_questions.php
|   |-- dashboard.php
|   |-- manage_questions.php
|   `-- view_results.php
|-- student/
|   |-- dashboard.php
|   |-- exam_list.php
|   |-- my_results.php
|   |-- result.php
|   |-- start_exam.php
|   `-- submit_exam.php
|-- index.php
`-- README.md
```

## Installation and Setup

### 1. Install a Local Server

Install one of the following:

- XAMPP
- WAMP
- MAMP
- Any local environment that supports PHP and MySQL

### 2. Copy the Project to the Web Root

For XAMPP, place the project folder inside:

```text
C:\xampp\htdocs\
```

Recommended folder path:

```text
C:\xampp\htdocs\apex-exam-online-examination-system
```

### 3. Start Services

Start the following services from your local server control panel:

- Apache
- MySQL

### 4. Create and Import the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Import this file:

```text
database/online_exam.sql
```

The script will create and use the `online_exam_db` database.

### 5. Configure Database Connection

Open:

```text
config/db.php
```

Update these values if your local MySQL configuration is different:

```php
$host = "localhost";
$user = "root";
$pass = "your_mysql_password";
$dbname = "online_exam_db";
$port = 3306;
```

### 6. Run the Application

Open the project in your browser:

```text
http://localhost/apex-exam-online-examination-system/index.php
```

## Default Login Accounts

The database seed includes these accounts:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@gmail.com` | `123456` |
| Lecturer | `lecturer@gmail.com` | `123456` |
| Student | `student@gmail.com` | `123456` |

## Application Workflow

### Admin Workflow

1. Log in as admin.
2. Add lecturers and students.
3. Create modules and assign lecturers.
4. Create exams under modules.
5. Configure exam instructions, duration, start time, and end time.
6. Monitor results after students submit exams.

### Lecturer Workflow

1. Log in as lecturer.
2. Open the lecturer dashboard.
3. Add questions to exams assigned through lecturer modules.
4. Manage existing questions.
5. Review submitted result records.

### Student Workflow

1. Register or log in as a student.
2. Open the available exams page.
3. Start an open exam.
4. Read instructions and confirm agreement.
5. Answer MCQ questions before the timer ends.
6. Submit manually or allow the timer to auto-submit.
7. View marks immediately and review result history later.

## Security and Validation Notes

- Database access uses prepared statements in the main form-processing flows.
- User passwords are stored as hashes, not plain text.
- Role-specific pages are protected by session checks.
- Student submissions are checked against exam attempts to reduce duplicate submissions.
- Exam submissions are validated against server-side deadlines, not only the browser timer.
- Output values are escaped with `htmlspecialchars()` across the main pages to reduce unsafe rendering.

## Current Limitations

- The project is intended for local educational/demo use.
- There is no email verification or password reset flow.
- Lecturer result pages currently list result records; advanced charts and analytics can be added later.
- Admin user editing is limited compared with module editing.
- File upload questions and essay questions are not included.

## Repository Description

Apex Exam is a PHP and MySQL online examination system with role-based dashboards, module and exam management, MCQ question handling, timed student exam attempts, auto-submit, instant marks, and result history.
