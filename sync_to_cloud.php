<?php
/**
 * Sync local MySQL (davao_jobs) -> Clever Cloud MySQL
 * Wipes remote tables and re-inserts everything from local.
 */

// ===================== CONFIGURATION =====================
$localHost   = '127.0.0.1';
$localUser   = 'root';
$localPass   = '';
$localDb     = 'davao_jobs';

$remoteHost  = 'bq5jiqemsif59sfmccah-mysql.services.clever-cloud.com';
$remotePort  = 3306;
$remoteUser  = 'uijkwku3pucpqv64';
$remotePass  = 'SMlSRuKvzebcOihHQXMr';
$remoteDb    = 'bq5jiqemsif59sfmccah';
// =========================================================

echo "=== Local MySQL -> Clever Cloud Sync ===\n\n";

// Connect local
try {
    $local = new PDO("mysql:host=$localHost;dbname=$localDb;charset=utf8mb4", $localUser, $localPass);
    $local->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[OK] Connected to LOCAL MySQL\n";
} catch (PDOException $e) {
    die("Cannot connect to local MySQL: " . $e->getMessage() . "\n");
}

// Connect remote
try {
    $remote = new PDO("mysql:host=$remoteHost;port=$remotePort;dbname=$remoteDb;charset=utf8mb4", $remoteUser, $remotePass);
    $remote->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[OK] Connected to CLEVER CLOUD MySQL\n\n";
} catch (PDOException $e) {
    die("Cannot connect to Clever Cloud: " . $e->getMessage() . "\n");
}

// Disable foreign key checks on remote
$remote->exec("SET FOREIGN_KEY_CHECKS = 0");

// Tables to sync in order
$tables = ['users', 'job_posts', 'applications', 'activity_logs'];

foreach ($tables as $table) {
    echo "--- Syncing '$table' ---\n";
    
    // Read all from local
    $stmt = $local->query("SELECT * FROM `$table`");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "  Local rows: " . count($rows) . "\n";
    
    if (empty($rows)) {
        echo "  Skipped (no data)\n\n";
        continue;
    }
    
    // Clear remote table
    $remote->exec("DELETE FROM `$table`");
    echo "  Remote table cleared\n";
    
    // Get columns from local data
    $columns = array_keys($rows[0]);
    $columnList = '`' . implode('`, `', $columns) . '`';
    $placeholders = implode(', ', array_fill(0, count($columns), '?'));
    
    $sql = "INSERT INTO `$table` ($columnList) VALUES ($placeholders)";
    $insertStmt = $remote->prepare($sql);
    
    $inserted = 0;
    $errors = 0;
    foreach ($rows as $row) {
        try {
            $insertStmt->execute(array_values($row));
            $inserted++;
        } catch (PDOException $e) {
            $errors++;
            echo "  [ERR] " . $e->getMessage() . "\n";
        }
    }
    echo "  Inserted: $inserted / " . count($rows);
    if ($errors > 0) echo " ($errors errors)";
    echo "\n\n";
}

// Re-enable foreign key checks
$remote->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "=== SYNC COMPLETE ===\n";
echo "Your Clever Cloud database now matches your local database!\n";
echo "You can now log in on your live website with the same credentials.\n";
