<?php
$pageTitle = "Create Student Account | Apex Exam";
$showNav = false;
include "../includes/header.php";
?>
<section class="page-splash auth-splash auth-center">
    <div class="splash-form centered-panel">
        <div class="auth-card auth-glass-card">
            <div class="auth-header auth-header-sm">
                <h2>Sign Up</h2>
                <p>Create a student account and access available exams and results.</p>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    $messages = [
                        'terms' => 'Please agree to the Apex Exam terms before continuing.',
                        'missing' => 'Please complete all required fields.',
                        'email' => 'Registration failed. This email may already exist.'
                    ];
                    echo htmlspecialchars($messages[$_GET['error']] ?? 'Registration failed. Please try again.');
                    ?>
                </div>
            <?php endif; ?>
            <form action="register_process.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create a secure password" required>
                </div>
                <div class="form-group checkbox-group">
                    <label class="checkbox-label"><input type="checkbox" name="terms" required> I agree to ApexExam terms and confirm the information is accurate.</label>
                </div>
                <button type="submit">Create Account</button>
                <a href="../index.php" class="btn btn-outline auth-secondary-btn">Back to Login</a>
            </form>
        </div>
    </div>
</section>
<?php include "../includes/footer.php"; ?>
