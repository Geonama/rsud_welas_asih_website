<?php

declare(strict_types=1);

$GLOBALS['config'] = require __DIR__ . '/../config/app.php';

require_once __DIR__ . '/helpers.php';

date_default_timezone_set(app_config('timezone'));

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-error.log');

if (session_status() === PHP_SESSION_NONE) {
    session_name(app_config('session_name'));
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/xlsx.php';

guard_session_timeout();
