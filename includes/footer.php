<?php
$basePath = "/online_examination_system";
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
