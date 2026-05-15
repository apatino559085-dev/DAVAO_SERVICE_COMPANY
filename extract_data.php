<?php
$db = new SQLite3('database/database.sqlite');

// List all tables
$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
echo "=== TABLES ===\n";
while($row = $tables->fetchArray()) {
    echo $row['name'] . "\n";
}

// Dump users
echo "\n=== USERS ===\n";
$result = $db->query("SELECT * FROM users");
while($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo json_encode($row) . "\n";
}

// Dump job_posts
echo "\n=== JOB_POSTS ===\n";
$result = $db->query("SELECT * FROM job_posts");
while($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo json_encode($row) . "\n";
}

// Dump applications
echo "\n=== APPLICATIONS ===\n";
$result = $db->query("SELECT * FROM applications");
while($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo json_encode($row) . "\n";
}

// Dump activity_logs
echo "\n=== ACTIVITY_LOGS ===\n";
$result = $db->query("SELECT * FROM activity_logs");
while($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo json_encode($row) . "\n";
}

$db->close();
echo "\n=== DONE ===\n";
