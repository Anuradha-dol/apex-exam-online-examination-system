<?php
require_once __DIR__ . "/base_path.php";
$basePath = appBasePath();
$isLandingFooter = !empty($isLanding);
?>
</main>
<footer class="site-footer <?= $isLandingFooter ? 'site-footer-landing' : '' ?>">
    <div class="site-footer-inner">
        <span>Apex Exam</span>
        <span>Secure online examination management</span>
    </div>
</footer>
</body>
</html>
