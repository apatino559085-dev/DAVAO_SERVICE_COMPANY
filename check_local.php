<?php
// Check local MySQL database
try {
    $local = new PDO('mysql:host=127.0.0.1;port=3306;dbname=davao_jobs', 'root', '');
    $local->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== LOCAL USERS ===\n";
    $stmt = $local->query("SELECT id, name, email, role, is_active FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $u) {
        echo "  ID:{$u['id']} | {$u['name']} | {$u['email']} | Role: {$u['role']} | Active: {$u['is_active']}\n";
    }
    echo "  Total: " . count($users) . " users\n\n";
    
    echo "=== LOCAL JOB POSTS ===\n";
    $stmt = $local->query("SELECT id, title, company, user_id FROM job_posts ORDER BY id");
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($jobs as $j) {
        echo "  ID:{$j['id']} | {$j['title']} | {$j['company']} | user_id: {$j['user_id']}\n";
    }
    echo "  Total: " . count($jobs) . " job posts\n\n";
    
    echo "=== LOCAL APPLICATIONS ===\n";
    $stmt = $local->query("SELECT id, job_post_id, user_id, status FROM applications ORDER BY id");
    $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($apps as $a) {
        echo "  ID:{$a['id']} | Job:{$a['job_post_id']} | User:{$a['user_id']} | Status: {$a['status']}\n";
    }
    echo "  Total: " . count($apps) . " applications\n\n";

    echo "=== LOCAL ACTIVITY LOGS ===\n";
    $stmt = $local->query("SELECT COUNT(*) as cnt FROM activity_logs");
    $cnt = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "  Total: {$cnt['cnt']} logs\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
