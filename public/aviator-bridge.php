<?php

/**
 * Shim that bootstraps the Aviator (crash) game Laravel app from the main
 * public/ directory. LiteSpeed on cPanel blocks PHP execution inside
 * games/avitorjetx/, so this file acts as the entry point instead.
 *
 * The root .htaccess rewrites /games/avitorjetx/* here, and we override
 * SCRIPT_NAME so the Aviator app computes the correct base path.
 */

$_SERVER['SCRIPT_NAME']     = '/games/avitorjetx/index.php';
$_SERVER['SCRIPT_FILENAME'] = realpath(__DIR__ . '/../games/avitorjetx/index.php') ?: __DIR__ . '/../games/avitorjetx/index.php';

define('LARAVEL_START', microtime(true));

$laravelBase = __DIR__ . '/../games/avitorjetx/laravel';

if (file_exists($maintenance = $laravelBase . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravelBase . '/vendor/autoload.php';

$app = require_once $laravelBase . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
