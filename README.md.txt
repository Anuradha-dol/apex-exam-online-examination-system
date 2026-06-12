# Apex Exam – Online Examination System

Apex Exam is a web-based Online Examination System developed using PHP, MySQL, HTML, CSS, and JavaScript. The system is designed to manage online exams through separate role-based dashboards for Admin, Lecturer, and Student users.

This project includes user authentication, module and exam management, student exam participation, smart exam timer with auto-submit, instant result generation, and result analytics/reporting.

---

## Project Name

**Apex Exam – Online Examination System**

---

## Technologies Used

* HTML
* CSS
* JavaScript
* PHP
* MySQL
* XAMPP
* phpMyAdmin

---

## Main Features

### Authentication & User Management

* User login
* User registration
* Logout functionality
* Session management
* Role-based access control
* Admin, Lecturer, and Student roles
* User profile handling

### Module & Exam Management

* Add, update, view, and manage modules
* Create exams
* Manage exam duration
* Manage exam schedule
* Assign exams/modules for students
* Lecturer-side exam/question management

### Smart Student Examination System

* Student dashboard
* View available exams
* Start exam
* Answer MCQ questions
* Submit exam
* Smart countdown timer
* Auto-submit when time ends
* Single attempt exam flow
* Instant result generation after submission

### Result Analytics & Reporting

* View exam results
* Student result history
* Admin result view
* Lecturer result view
* Performance reporting
* Pass/fail analysis
* Average, highest, and lowest mark tracking

---

## Team Members and Contributions

### Anuradha

**Part:** Smart Student Examination System

Anuradha handled the student-side examination process. This includes viewing exams, starting exams, answering MCQ questions, submitting exams, smart timer handling, auto-submit functionality, and instant result generation.

**Advanced Function:** Smart Timer with Auto Submit

---

### Damsi / Dasmi

**Part:** Result Analytics & Reporting

Damsi handled the result management and reporting section. This includes viewing student results, exam result history, admin/lecturer result views, performance reports, and dashboard analytics.

**Advanced Function:** Result Analytics Dashboard

---

### Supuni

**Part:** Authentication & User Management

Supuni handled login, registration, logout, session handling, role-based access control, and user management features.

---

### Pabasha

**Part:** Module & Exam Management

Pabasha handled module management and exam management. This includes module CRUD operations, exam creation, exam schedule, exam duration, and lecturer-side exam/question handling.

---

## User Roles

### Admin

The admin can manage users, modules, exams, and view results and reports.

### Lecturer

The lecturer can manage exam-related content, questions, and view student results.

### Student

The student can view available exams, start exams, answer questions, submit exams, and view results.

---

## How to Run the Project

### Step 1: Install XAMPP

Download and install XAMPP on your computer.

### Step 2: Start Apache and MySQL

Open XAMPP Control Panel and start:

* Apache
* MySQL

### Step 3: Move Project Folder

Copy the project folder into the XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\online_examination_system
```

### Step 4: Create Database

Open phpMyAdmin using your browser:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
online_exam_db
```

### Step 5: Import Database

Import the SQL file from the project database folder into the created database.

Example:

```text
database/online_exam.sql
```

### Step 6: Run the Project

Open the project in your browser:

```text
http://localhost/online_examination_system
```

---

## Folder Structure

```text
online_examination_system/
│
├── admin/
│   └── Admin related pages
│
├── lecturer/
│   └── Lecturer related pages
│
├── student/
│   └── Student examination pages
│
├── auth/
│   └── Login, register, logout, and authentication pages
│
├── config/
│   └── Database connection files
│
├── includes/
│   └── Common header, footer, and shared files
│
├── assets/
│   └── CSS, JavaScript, images, and design assets
│
├── database/
│   └── SQL database file
│
└── README.md
```

---

## Advanced Features

### Smart Timer with Auto Submit

The student examination page includes a countdown timer. When the exam time is over, the system automatically submits the exam to prevent late submissions.

### Instant Result Generation

After submitting the exam, the student can receive marks based on the submitted answers.

### Result Analytics

The result section helps admins and lecturers analyze student performance using result history and report-based views.

---

## Project Purpose

The main purpose of Apex Exam is to provide a simple and effective online examination platform for educational institutes. It helps admins, lecturers, and students manage the examination process in a more organized way.

---

## GitHub Repository Name

```text
apex-exam-online-examination-system
```

---

## GitHub Repository Description

```text
Apex Exam is a PHP and MySQL online examination system with role-based login, exam management, smart student exam flow, auto-submit timer, instant results, and result reporting.
```

---

## Branch Names

```text
Smart-Student-Examination-System
Result-Analytics-Reporting
Auth-User-Management
Module-Exam-Management
```

---

run 

http://localhost/apex-exam-online-examination-system/index.php

## Conclusion

Apex Exam is a complete online examination system that supports multiple user roles and important exam-related features. The project focuses on exam management, secure student exam flow, automatic submission, instant results, and result reporting.
