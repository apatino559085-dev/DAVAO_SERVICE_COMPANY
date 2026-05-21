<?php
/**
 * SQLite to MySQL Migration Script
 * 
 * This script:
 * 1. Creates the 'davao_jobs' database in MySQL (via phpMyAdmin/MySQL)
 * 2. Creates all required tables with proper MySQL schema
 * 3. Migrates all data from SQLite to MySQL
 * 
 * Run: php migrate_to_mysql.php
 */

// ===================== CONFIGURATION =====================
$mysqlHost = 'bq5jiqemsif59sfmccah-mysql.services.clever-cloud.com';
$mysqlPort = 3306;
$mysqlUser = 'uijkwku3pucpqv64';
$mysqlPass = 'SMlSRuKvzebcOihHQXMr';
$mysqlDbName = 'bq5jiqemsif59sfmccah';
$sqliteFile = __DIR__ . '/database/database.sqlite';
// =========================================================

echo "=== SQLite to MySQL Migration Tool ===\n\n";

// Step 1: Connect to SQLite and read all data FIRST
echo "[1/5] Connecting to SQLite...\n";
if (!file_exists($sqliteFile)) {
    die("ERROR: SQLite database not found at: $sqliteFile\n");
}

try {
    $sqlite = new PDO("sqlite:$sqliteFile");
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "  ✓ Connected to SQLite\n";
} catch (PDOException $e) {
    die("ERROR: Cannot connect to SQLite: " . $e->getMessage() . "\n");
}

// Read all data from SQLite
echo "\n[2/5] Reading data from SQLite...\n";

$data = [];

// Read users
$stmt = $sqlite->query("SELECT * FROM users");
$data['users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "  ✓ Users: " . count($data['users']) . " records\n";

// Read job_posts
$stmt = $sqlite->query("SELECT * FROM job_posts");
$data['job_posts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "  ✓ Job Posts: " . count($data['job_posts']) . " records\n";

// Read applications
$stmt = $sqlite->query("SELECT * FROM applications");
$data['applications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "  ✓ Applications: " . count($data['applications']) . " records\n";

// Read activity_logs
$stmt = $sqlite->query("SELECT * FROM activity_logs");
$data['activity_logs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "  ✓ Activity Logs: " . count($data['activity_logs']) . " records\n";

// Print data preview
echo "\n--- DATA PREVIEW ---\n";
foreach ($data['users'] as $u) {
    echo "  User: {$u['name']} ({$u['email']}) - Role: {$u['role']}\n";
}
foreach ($data['job_posts'] as $jp) {
    echo "  Job: {$jp['title']} @ {$jp['company']}\n";
}
foreach ($data['applications'] as $app) {
    echo "  Application ID: {$app['id']} - Status: {$app['status']}\n";
}
echo "--------------------\n";

// Step 2: Connect to MySQL (without database first to create it)
echo "\n[3/5] Connecting to MySQL and creating database...\n";

try {
    $mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort", $mysqlUser, $mysqlPass);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "  ✓ Connected to MySQL server\n";
} catch (PDOException $e) {
    die("ERROR: Cannot connect to MySQL. Is XAMPP/MySQL running?\n" . $e->getMessage() . "\n");
}

// Create database
$mysql->exec("CREATE DATABASE IF NOT EXISTS `$mysqlDbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "  ✓ Database '$mysqlDbName' created/confirmed\n";

// Switch to database
$mysql->exec("USE `$mysqlDbName`");
echo "  ✓ Using database '$mysqlDbName'\n";

// Step 3: Create all tables
echo "\n[4/5] Creating tables...\n";

// Drop existing tables in correct order (respect foreign keys)
$mysql->exec("SET FOREIGN_KEY_CHECKS = 0");
$dropTables = ['activity_logs', 'applications', 'job_posts', 'failed_jobs', 'job_batches', 'jobs', 'cache_locks', 'cache', 'sessions', 'password_reset_tokens', 'users', 'migrations'];
foreach ($dropTables as $t) {
    $mysql->exec("DROP TABLE IF EXISTS `$t`");
}
$mysql->exec("SET FOREIGN_KEY_CHECKS = 1");

// Create migrations table
$mysql->exec("
CREATE TABLE `migrations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ migrations table\n";

// Create users table
$mysql->exec("
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `address` VARCHAR(255) NULL DEFAULT NULL,
    `role` VARCHAR(255) NOT NULL DEFAULT 'applicant',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ users table\n";

// Create password_reset_tokens table
$mysql->exec("
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ password_reset_tokens table\n";

// Create sessions table
$mysql->exec("
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` TEXT NULL DEFAULT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ sessions table\n";

// Create cache table
$mysql->exec("
CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    INDEX `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ cache table\n";

// Create cache_locks table
$mysql->exec("
CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    INDEX `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ cache_locks table\n";

// Create jobs table (Laravel queue)
$mysql->exec("
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ jobs table\n";

// Create job_batches table
$mysql->exec("
CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL DEFAULT NULL,
    `cancelled_at` INT NULL DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ job_batches table\n";

// Create failed_jobs table
$mysql->exec("
CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ failed_jobs table\n";

// Create job_posts table (with ALL columns from all migrations)
$mysql->exec("
CREATE TABLE `job_posts` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `company` VARCHAR(255) NOT NULL,
    `logo_path` VARCHAR(255) NULL DEFAULT NULL,
    `location` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `salary` VARCHAR(255) NULL DEFAULT NULL,
    `type` VARCHAR(255) NOT NULL DEFAULT 'full-time',
    `industry` VARCHAR(255) NULL DEFAULT NULL,
    `requirements` TEXT NULL DEFAULT NULL,
    `expires_at` DATE NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `job_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ job_posts table\n";

// Create applications table (with ALL columns from all migrations)
$mysql->exec("
CREATE TABLE `applications` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `job_post_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `cover_letter` TEXT NULL DEFAULT NULL,
    `resume_path` VARCHAR(255) NULL DEFAULT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
    `is_archived` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `interview_at` DATETIME NULL DEFAULT NULL,
    `interview_location` VARCHAR(255) NULL DEFAULT NULL,
    `rating` INT NULL DEFAULT NULL,
    `id_picture_path` VARCHAR(255) NULL DEFAULT NULL,
    `certificates_path` VARCHAR(255) NULL DEFAULT NULL,
    CONSTRAINT `applications_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ applications table\n";

// Create activity_logs table
$mysql->exec("
CREATE TABLE `activity_logs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `action` VARCHAR(255) NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");
echo "  ✓ activity_logs table\n";

// Insert migration records
$migrations = [
    ['0001_01_01_000000_create_users_table', 1],
    ['0001_01_01_000001_create_cache_table', 1],
    ['0001_01_01_000002_create_jobs_table', 1],
    ['2026_04_09_182504_create_job_posts_table', 1],
    ['2026_04_09_182534_create_applications_table', 1],
    ['2026_04_16_121453_add_is_active_to_users_table', 1],
    ['2026_04_20_152554_add_resume_path_to_applications_table', 1],
    ['2026_04_20_153045_add_logo_path_to_job_posts_table', 1],
    ['2026_04_20_154857_add_industry_to_job_posts_table', 1],
    ['2026_04_20_162206_add_is_archived_to_applications_table', 1],
    ['2026_04_22_123852_add_interview_and_evaluation_to_applications_table', 1],
    ['2026_04_22_123852_add_requirements_and_deadline_to_job_posts_table', 1],
    ['2026_04_22_123852_create_activity_logs_table', 1],
];

$migStmt = $mysql->prepare("INSERT INTO `migrations` (`migration`, `batch`) VALUES (?, ?)");
foreach ($migrations as $mig) {
    $migStmt->execute($mig);
}
echo "  ✓ migration records inserted (" . count($migrations) . " records)\n";

// Step 4: Insert all data
echo "\n[5/5] Inserting data into MySQL...\n";

// Disable foreign key checks for data insertion
$mysql->exec("SET FOREIGN_KEY_CHECKS = 0");

// Helper function to insert data
function insertData(PDO $mysql, string $table, array $rows)
{
    if (empty($rows)) {
        echo "  ⚠ $table: No data to insert\n";
        return;
    }

    $columns = array_keys($rows[0]);
    $placeholders = '(' . implode(', ', array_fill(0, count($columns), '?')) . ')';
    $columnList = '`' . implode('`, `', $columns) . '`';

    $sql = "INSERT INTO `$table` ($columnList) VALUES $placeholders";
    $stmt = $mysql->prepare($sql);

    $inserted = 0;
    foreach ($rows as $row) {
        try {
            $values = array_values($row);
            $stmt->execute($values);
            $inserted++;
        } catch (PDOException $e) {
            echo "  ✗ Error inserting into $table: " . $e->getMessage() . "\n";
            echo "    Row data: " . json_encode($row) . "\n";
        }
    }
    echo "  ✓ $table: $inserted/" . count($rows) . " records inserted\n";
}

// Insert users
insertData($mysql, 'users', $data['users']);

// Insert job_posts
insertData($mysql, 'job_posts', $data['job_posts']);

// Insert applications
insertData($mysql, 'applications', $data['applications']);

// Insert activity_logs
insertData($mysql, 'activity_logs', $data['activity_logs']);

// Re-enable foreign key checks
$mysql->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "\n=== MIGRATION COMPLETE ===\n";
echo "\nData successfully migrated to MySQL database '$mysqlDbName'!\n";
echo "\nNext steps:\n";
echo "  1. Update your .env file (will be done automatically)\n";
echo "  2. Clear Laravel cache: php artisan config:clear\n";
echo "  3. Test: php artisan serve\n\n";

// Close connections
$sqlite = null;
$mysql = null;
