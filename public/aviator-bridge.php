<?php

/**
 * Shim that bootstraps the Aviator (crash) game Laravel app from the main
 * public/ directory. LiteSpeed on cPanel blocks PHP execution inside
 * games/avitorjetx/, so this file acts as the entry point instead.
 *
 * The root .htaccess rewrites /games/avitorjetx/* here, and we override
 * SCRIPT_NAME so the Aviator app computes the correct base path.
 */

ini_set('display_errors', '1');
error_reporting(E_ALL);

$_SERVER['SCRIPT_NAME']     = '/games/avitorjetx/index.php';
$_SERVER['SCRIPT_FILENAME'] = realpath(__DIR__ . '/../games/avitorjetx/index.php') ?: __DIR__ . '/../games/avitorjetx/index.php';

define('LARAVEL_START', microtime(true));

$laravelBase = __DIR__ . '/../games/avitorjetx/laravel';

if (! is_dir($laravelBase)) {
    http_response_code(500);
    echo 'Aviator laravel directory not found at: ' . realpath(__DIR__ . '/../games/avitorjetx') . '/laravel';
    exit(1);
}

if (file_exists($maintenance = $laravelBase . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

try {
    require $laravelBase . '/vendor/autoload.php';

    $app = require_once $laravelBase . '/bootstrap/app.php';

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = \Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "Aviator bridge error:\n";
    echo $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
