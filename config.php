<?php
// Database Configuration
define('DB_HOST', '10.4.1.28');
define('DB_USER', 'apollo');
define('DB_PASS', 'Apollo123');
define('DB_NAME', 'vlog_planner');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

$conn->set_charset("utf8");
