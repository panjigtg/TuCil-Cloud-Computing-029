<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jika request ke root atau tidak ada file, serve index.php
if ($uri === '/' || !file_exists(__DIR__ . $uri)) {
    require __DIR__ . '/index.php';
    exit;
}

return false;
?>