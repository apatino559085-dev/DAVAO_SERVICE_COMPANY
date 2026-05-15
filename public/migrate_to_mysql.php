<?php
/**
 * Migration script: SQLite -> MySQL (davao_job)
 * Access via browser: http://127.0.0.1:8000/migrate_to_mysql.php
 * 
 * This script:
 * 1. Reads all data from SQLite
 * 2. Creates tables in MySQL davao_job database
 * 3. Inserts all data
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>SQLite to MySQL Migration Tool</h1>";
echo "<pre>";

// Step 1: Connect to SQLite
$sqlitePath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($sqlitePath)) {
    die("ERROR: SQLite database not found at: $sqlitePath");
}

try {
    $sqlite = new PDO("sqlite:$sqlitePath");
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to SQLite\n";
} catch (PDOException $e) {
    die("SQLite connection failed: " . $e->getMessage());
}

// Step 2: Connect to MySQL
try {
    $mysql = new PDO("mysql:host=127.0.0.1;port=3306", "root", "");
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to MySQL\n";
} catch (PDOException $e) {
    die("MySQL connection failed: " . $e->getMessage());
}

// Step 3: Create database if not exists
$mysql->exec("CREATE DATABASE IF NOT EXISTS `davao_job` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$mysql->exec("USE `davao_job`");
echo "✅ Using database: davao_job\n\n";

// Step 4: Create tables
echo "=== CREATING TABLES ===\n";

// Users table
$mysql->exec("DROP TABLE IF EXISTS `activity_logs`");
$mysql->exec("DROP TABLE IF EXISTS `applications`");
$mysql->exec("DROP TABLE IF EXISTS `job_posts`");
$mysql->exec("DROP TABLE IF EXISTS `sessions`");
$mysql->exec("DROP TABLE IF EXISTS `password_reset_tokens`");
$mysql->exec("DROP TABLE IF EXISTS `cache_locks`");
$mysql->exec("DROP TABLE IF EXISTS `cache`");
$mysql->exec("DROP TABLE IF EXISTS `failed_jobs`");
$mysql->exec("DROP TABLE IF EXISTS `job_batches`");
$mysql->exec("DROP TABLE IF EXISTS `jobs`");
$mysql->exec("DROP TABLE IF EXISTS `migrations`");
$mysql->exec("DROP TABLE IF EXISTS `users`");

// users
$mysql->exec("CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `address` VARCHAR(255) NULL,
    `role` VARCHAR(255) NOT NULL DEFAULT 'applicant',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: users\n";

// password_reset_tokens
$mysql->exec("CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: password_reset_tokens\n";

// sessions
$mysql->exec("CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: sessions\n";

// cache
$mysql->exec("CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: cache\n";

// cache_locks
$mysql->exec("CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: cache_locks\n";

// jobs (Laravel queue)
$mysql->exec("CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: jobs\n";

// job_batches
$mysql->exec("CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: job_batches\n";

// failed_jobs
$mysql->exec("CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: failed_jobs\n";

// job_posts
$mysql->exec("CREATE TABLE `job_posts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `company` VARCHAR(255) NOT NULL,
    `logo_path` VARCHAR(255) NULL,
    `location` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `salary` VARCHAR(255) NULL,
    `type` VARCHAR(255) NOT NULL DEFAULT 'full-time',
    `industry` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `requirements` TEXT NULL,
    `expires_at` DATE NULL,
    CONSTRAINT `job_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: job_posts\n";

// applications
$mysql->exec("CREATE TABLE `applications` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `job_post_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `cover_letter` TEXT NULL,
    `resume_path` VARCHAR(255) NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
    `is_archived` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `interview_at` DATETIME NULL,
    `interview_location` VARCHAR(255) NULL,
    `rating` INT NULL,
    `id_picture_path` VARCHAR(255) NULL,
    `certificates_path` VARCHAR(255) NULL,
    CONSTRAINT `applications_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: applications\n";

// activity_logs
$mysql->exec("CREATE TABLE `activity_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `action` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: activity_logs\n";

// migrations table (Laravel tracking)
$mysql->exec("CREATE TABLE `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
echo "✅ Created: migrations\n";

echo "\n=== MIGRATING DATA ===\n";

// Helper function to migrate data
function migrateTable($sqlite, $mysql, $tableName, $columns) {
    $result = $sqlite->query("SELECT * FROM `$tableName`");
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    $count = count($rows);
    
    if ($count === 0) {
        echo "⚪ $tableName: 0 rows (empty)\n";
        return;
    }
    
    foreach ($rows as $row) {
        $cols = array_keys($row);
        $placeholders = array_map(function($c) { return ":$c"; }, $cols);
        $colList = implode(', ', array_map(function($c) { return "`$c`"; }, $cols));
        $phList = implode(', ', $placeholders);
        
        $stmt = $mysql->prepare("INSERT INTO `$tableName` ($colList) VALUES ($phList)");
        foreach ($row as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
    }
    
    echo "✅ $tableName: $count rows migrated\n";
}

// Migrate each table (order matters for foreign keys)
$tablesToMigrate = [
    'users',
    'password_reset_tokens',
    'job_posts',
    'applications',
    'activity_logs',
    'jobs',
    'job_batches',
    'failed_jobs',
    'cache',
    'cache_locks',
    'migrations',
];

foreach ($tablesToMigrate as $table) {
    try {
        // Check if table exists in SQLite
        $check = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'");
        if ($check->fetch()) {
            migrateTable($sqlite, $mysql, $table);
        } else {
            echo "⚪ $table: table not found in SQLite (skipped)\n";
        }
    } catch (Exception $e) {
        echo "❌ $table: " . $e->getMessage() . "\n";
    }
}

echo "\n=== MIGRATION COMPLETE ===\n";
echo "\nAll data has been migrated from SQLite to MySQL (davao_job).\n";
echo "Now update your .env file:\n";
echo "  DB_CONNECTION=mysql\n";
echo "  DB_HOST=127.0.0.1\n";
echo "  DB_PORT=3306\n";
echo "  DB_DATABASE=davao_job\n";
echo "  DB_USERNAME=root\n";
echo "  DB_PASSWORD=\n";
echo "</pre>";
