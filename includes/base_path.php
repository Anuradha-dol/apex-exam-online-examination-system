<?php
function appBasePath() {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $scriptPath = parse_url($scriptName, PHP_URL_PATH) ?: '';
    $scriptDir = str_replace('\\', '/', dirname($scriptPath));

    $basePath = preg_replace('#/(admin|auth|lecturer|student)$#', '', $scriptDir);

    return $basePath === '/' ? '' : $basePath;
}
?>
