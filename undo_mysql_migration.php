<?php
/**
 * UNDO MySQL Migration - Revert back to SQLite
 * 
 * This script:
 * 1. Restores the .env file to use SQLite
 * 2. Clears Laravel config cache
 * 
 * Run: php undo_mysql_migration.php
 */

echo "=== UNDO MySQL Migration ===\n\n";

$envFile = __DIR__ . '/.env';
$backupFile = __DIR__ . '/.env.backup_sqlite';

// Check if backup exists
if (!file_exists($backupFile)) {
    die("ERROR: No SQLite backup found at .env.backup_sqlite\n");
}

// Check if SQLite database still exists
$sqliteFile = __DIR__ . '/database/database.sqlite';
if (!file_exists($sqliteFile)) {
    die("ERROR: SQLite database file not found! Cannot revert.\n");
}

// Restore .env from backup
echo "[1/2] Restoring .env from backup...\n";
$backupContent = file_get_contents($backupFile);
file_put_contents($envFile, $backupContent);
echo "  ✓ .env restored to SQLite configuration\n";

// Clear config cache
echo "\n[2/2] Clearing Laravel cache...\n";
echo "  Running: php artisan config:clear\n";
exec('php artisan config:clear 2>&1', $output, $returnCode);
echo "  " . implode("\n  ", $output) . "\n";

if ($returnCode === 0) {
    echo "\n=== UNDO COMPLETE ===\n";
    echo "\nYour project is now using SQLite again.\n";
    echo "Run: php artisan serve\n";
} else {
    echo "\n=== UNDO PARTIAL ===\n";
    echo ".env has been restored. Please manually run: php artisan config:clear\n";
}
