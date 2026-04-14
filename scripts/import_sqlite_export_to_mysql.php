#!/usr/bin/env php
<?php

/**
 * Import database/exports/sqlite_export_for_mysql.sql into MySQL using .env credentials.
 * Requires DB_CONNECTION=mysql (and DB_* host/database/user/password) on the target run.
 *
 * Passes through flags like --with-migrate to tmp_import_sql.php.
 *
 *   php scripts/import_sqlite_export_to_mysql.php
 *   php scripts/import_sqlite_export_to_mysql.php --with-migrate
 */

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

$repoRoot = dirname(__DIR__);
$export = $repoRoot.'/database/exports/sqlite_export_for_mysql.sql';

if (! is_readable($export)) {
    fwrite(STDERR, "Missing export file. Generate it first:\n");
    fwrite(STDERR, "  php scripts/export_sqlite_for_mysql.php\n");
    fwrite(STDERR, "Expected: {$export}\n");
    exit(1);
}

$exportHead = (string) file_get_contents($export, false, null, 0, 65536);
if (str_contains($exportHead, 'INSERT INTO `migrations`')) {
    fwrite(STDERR, "This export is outdated: it still contains INSERTs into `migrations`, which always conflicts after migrate:fresh.\n");
    fwrite(STDERR, "Update the file from git (your pull may not have merged — try: git fetch origin && git merge origin/main)\n");
    fwrite(STDERR, "or re-upload database/exports/sqlite_export_for_mysql.sql from the latest repo.\n");
    exit(1);
}
if (! str_contains($exportHead, 'Skips: migrations')) {
    fwrite(STDERR, "Warning: export header does not mention skipping migrations; ensure you use the latest sqlite_export_for_mysql.sql.\n");
}

$cmd = [PHP_BINARY, $repoRoot.'/scripts/tmp_import_sql.php', $export];
foreach (array_slice($argv, 1) as $arg) {
    $cmd[] = $arg;
}

$line = '';
foreach ($cmd as $i => $part) {
    $line .= ($i > 0 ? ' ' : '').escapeshellarg($part);
}

passthru($line, $code);
exit($code);
