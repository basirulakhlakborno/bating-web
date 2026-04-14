#!/usr/bin/env php
<?php

/**
 * One-off SQL import using credentials from the project .env (MySQL only).
 *
 * SECURITY: Remove this file from the server as soon as import succeeds.
 * Do not leave it on a public document root; run only over SSH:
 *
 *   cd /path/to/project
 *   # Put mysqldump output here:
 *   # import.sql  (same directory as artisan — project root)
 *   php scripts/tmp_import_sql.php
 *   php scripts/tmp_import_sql.php /path/to/dump.sql
 *   php scripts/tmp_import_sql.php database/exports/sqlite_export_for_mysql.sql
 *   php scripts/import_sqlite_export_to_mysql.php   # same as line above (+ optional --with-migrate)
 *   php scripts/tmp_import_sql.php --with-migrate   # migrate --force, then import
 *
 * Full mysqldump (with DROP/CREATE): import usually replaces migrations — do not use --with-migrate.
 * Data-only SQL: run migrations first, then import, or use --with-migrate.
 */

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

$repoRoot = dirname(__DIR__);
$envPath = $repoRoot.'/.env';
$sqlPath = $repoRoot.'/import.sql';

$withMigrate = false;
foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--with-migrate') {
        $withMigrate = true;
    } elseif ($arg !== '' && $arg[0] !== '-') {
        $sqlPath = $arg;
        if ($sqlPath[0] !== '/') {
            $sqlPath = $repoRoot.'/'.ltrim($sqlPath, '/');
        }
    }
}

function parse_env_file(string $path): array
{
    $out = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $eq = strpos($line, '=');
        if ($eq === false) {
            continue;
        }
        $key = trim(substr($line, 0, $eq));
        $val = trim(substr($line, $eq + 1));
        if ($val !== '' && ($val[0] === '"' && str_ends_with($val, '"'))) {
            $val = stripcslashes(substr($val, 1, -1));
        } elseif ($val !== '' && ($val[0] === "'" && str_ends_with($val, "'"))) {
            $val = substr($val, 1, -1);
        }
        $out[$key] = $val;
    }

    return $out;
}

if (! is_readable($envPath)) {
    fwrite(STDERR, "Missing or unreadable .env at {$envPath}\n");
    exit(1);
}

if (! is_readable($sqlPath)) {
    fwrite(STDERR, "Missing or unreadable SQL file: {$sqlPath}\n");
    fwrite(STDERR, "Upload your .sql to the project root as import.sql, or run:\n");
    fwrite(STDERR, "  php scripts/tmp_import_sql.php /full/path/to/your_dump.sql\n");
    exit(1);
}

$env = parse_env_file($envPath);
$driver = $env['DB_CONNECTION'] ?? 'mysql';

if ($driver !== 'mysql') {
    fwrite(STDERR, "This helper only supports DB_CONNECTION=mysql (got {$driver}).\n");
    exit(1);
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = (int) ($env['DB_PORT'] ?? 3306);
$database = $env['DB_DATABASE'] ?? '';
$user = $env['DB_USERNAME'] ?? '';
$password = $env['DB_PASSWORD'] ?? '';

if ($database === '' || $user === '') {
    fwrite(STDERR, "DB_DATABASE and DB_USERNAME must be set in .env\n");
    exit(1);
}

if ($withMigrate) {
    $php = PHP_BINARY;
    $artisan = $repoRoot.'/artisan';
    $cmd = escapeshellarg($php).' '.escapeshellarg($artisan).' migrate --force';
    fwrite(STDERR, "Running: {$cmd}\n");
    passthru($cmd, $code);
    if ($code !== 0) {
        fwrite(STDERR, "migrate failed (exit {$code})\n");
        exit($code);
    }
}

$sql = file_get_contents($sqlPath);
if ($sql === false || $sql === '') {
    fwrite(STDERR, "import.sql is empty or unreadable\n");
    exit(1);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli($host, $user, $password, $database, $port);
} catch (Throwable $e) {
    fwrite(STDERR, 'Connection failed: '.$e->getMessage()."\n");
    exit(1);
}

$mysqli->set_charset('utf8mb4');

/**
 * Run one statement at a time so errors name the failing SQL (our exports use one statement per line).
 */
try {
    $lineNum = 0;
    foreach (preg_split("/\r\n|\n|\r/", $sql) as $line) {
        $lineNum++;
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '--')) {
            continue;
        }
        if (! str_ends_with($line, ';')) {
            fwrite(STDERR, "Import failed at line {$lineNum}: expected a single-line statement ending with ';'.\n");
            fwrite(STDERR, "If this file was hand-edited, merge long statements onto one line or extend tmp_import_sql.php.\n");
            exit(1);
        }
        $statement = substr($line, 0, -1);
        if (trim($statement) === '') {
            continue;
        }
        $mysqli->query($statement);
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'Import failed: '.$e->getMessage()."\n");
    if (isset($statement)) {
        $preview = strlen($statement) > 280 ? substr($statement, 0, 280).'…' : $statement;
        fwrite(STDERR, "Failed statement (line {$lineNum}): {$preview}\n");
    }
    exit(1);
}

$mysqli->close();

echo "Import finished OK.\n";
echo "Delete from the server: scripts/tmp_import_sql.php and import.sql (and keep import.sql out of git).\n";
