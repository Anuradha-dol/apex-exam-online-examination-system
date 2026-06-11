<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') header("Location: admin/dashboard.php");
    if ($_SESSION['role'] == 'lecturer') header("Location: lecturer/dashboard.php");
    if ($_SESSION['role'] == 'student') header("Location: student/dashboard.php");
}
$pageTitle = "Apex Exam | Online Examination System";
$isLanding = true;
$showNav = true;
$containerClass = "landing-container";
include "includes/header.php";
?>

<section class="landing-hero" id="home">
    <div class="landing-hero-overlay"></div>
    <div class="landing-hero-content">
        <p class="eyebrow">Smart Exams. Secure Results. Better Future.</p>
        <h1>Apex Exam</h1>
        <p class="hero-lead">The smarter way to take exams online with timed delivery, fair participation controls, and instant result tracking for students, lecturers, and admins.</p>
        <div class="hero-actions">
            <a href="#login" class="btn">Get Started</a>
            <a href="#features" class="btn btn-ghost">View Features</a>
        </div>
    </div>
    <div class="hero-feature-rail" aria-label="Apex Exam strengths">
        <article class="hero-feature">
            <span class="feature-icon">S</span>
            <div>
                <h3>Secure & Reliable</h3>
                <p>Role-based access and controlled exam attempts.</p>
            </div>
        </article>
        <article class="hero-feature">
            <span class="feature-icon">T</span>
            <div>
                <h3>Timed Exams</h3>
                <p>Countdown delivery with server-side submission checks.</p>
            </div>
        </article>
        <article class="hero-feature">
            <span class="feature-icon">R</span>
            <div>
                <h3>Real-time Results</h3>
                <p>Marks are calculated as soon as an exam is submitted.</p>
            </div>
        </article>
        <article class="hero-feature">
            <span class="feature-icon">A</span>
            <div>
                <h3>Accessible Anywhere</h3>
                <p>Responsive screens for laptops, tablets, and phones.</p>
            </div>
        </article>
    </div>
</section>

<section class="landing-section" id="about">
    <div class="section-heading">
        <span class="eyebrow">About</span>
        <h2>Designed for focused online assessment workflows.</h2>
    </div>
    <div class="info-grid">
        <article class="info-panel">
            <h3>For students</h3>
            <p>Find available exams, read instructions, complete timed papers, and review marks from one portal.</p>
        </article>
        <article class="info-panel">
            <h3>For lecturers</h3>
            <p>Create questions, manage assessments, and inspect submitted results without switching systems.</p>
        </article>
        <article class="info-panel">
            <h3>For admins</h3>
            <p>Manage modules, users, exam schedules, and result records with a consistent control panel.</p>
        </article>
    </div>
</section>

<section class="landing-section section-muted" id="features">
    <div class="section-heading">
        <span class="eyebrow">Features</span>
        <h2>Controls that keep exam sessions clear and dependable.</h2>
    </div>
    <div class="feature-grid">
        <article class="feature-card">
            <span class="feature-icon">01</span>
            <h3>Availability Windows</h3>
            <p>Start and end times decide when students can participate.</p>
        </article>
        <article class="feature-card">
            <span class="feature-icon">02</span>
            <h3>Single Attempt Guard</h3>
            <p>Completed exams cannot be submitted again by direct URL or POST.</p>
        </article>
        <article class="feature-card">
            <span class="feature-icon">03</span>
            <h3>Accurate Scoring</h3>
            <p>Unanswered questions count toward the total and selected answers are checked against the exam.</p>
        </article>
        <article class="feature-card">
            <span class="feature-icon">04</span>
            <h3>Responsive UI</h3>
            <p>Tables, forms, cards, and exam questions adapt without overlapping.</p>
        </article>
    </div>
</section>

<section class="landing-section" id="workflow">
    <div class="section-heading">
        <span class="eyebrow">How It Works</span>
        <h2>A simple path from setup to submission.</h2>
    </div>
    <div class="workflow">
        <article>
            <span>1</span>
            <h3>Create modules and exams</h3>
            <p>Admins define the exam schedule and module ownership.</p>
        </article>
        <article>
            <span>2</span>
            <h3>Add questions</h3>
            <p>Lecturers attach MCQ questions to active exams.</p>
        </article>
        <article>
            <span>3</span>
            <h3>Start and submit</h3>
            <p>Students join during the allowed window and submit before time expires.</p>
        </article>
    </div>
</section>

<section class="landing-section login-section" id="login">
    <div class="login-copy">
        <span class="eyebrow">Portal Access</span>
        <h2>Sign in to continue.</h2>
        <p>Use your student, lecturer, or admin account to open the correct dashboard.</p>
    </div>
    <div class="auth-card">
        <div class="auth-header auth-header-sm">
            <h2>Login</h2>
            <p>Enter your credentials to continue to your exam dashboard.</p>
        </div>
        <?php if (isset($_GET['login']) && $_GET['login'] === 'failed'): ?>
            <div class="alert alert-danger">Invalid email or password.</div>
        <?php elseif (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Account created. You can sign in now.</div>
        <?php endif; ?>
        <form action="auth/login_process.php" method="POST" class="auth-form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Login</button>
            <a href="auth/register.php" class="btn btn-outline auth-secondary-btn">Create student account</a>
        </form>
    </div>
</section>
<?php include "includes/footer.php"; ?>
