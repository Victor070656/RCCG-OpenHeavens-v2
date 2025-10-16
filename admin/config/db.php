<?php
/**
 * Database Configuration
 * RCCG Open Heavens Parish Admin Panel
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'oh_church');

// Create connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Helper function to sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Helper function for prepared statements
function db_query($query, $params = [], $types = "") {
    global $conn;

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        return false;
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();

    return $stmt;
}
?>
