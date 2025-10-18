<?php
// Handle contact form submissions
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Include database connection
require_once '../config/db.php';

// Initialize response
$response = ['success' => false, 'message' => ''];

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get and sanitize form data
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($first_name) || empty($last_name)) {
        throw new Exception('Please provide your full name');
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Please provide a valid email address');
    }

    if (empty($subject)) {
        throw new Exception('Please select a subject');
    }

    if (empty($message)) {
        throw new Exception('Please provide a message');
    }

    // Combine first and last name
    $full_name = $first_name . ' ' . $last_name;

    // Prepare and execute insert query
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, status) VALUES (?, ?, ?, ?, ?, 'new')");

    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }

    $stmt->bind_param("sssss", $full_name, $email, $phone, $subject, $message);

    if (!$stmt->execute()) {
        throw new Exception('Failed to save message: ' . $stmt->error);
    }

    $stmt->close();

    // Success response
    $response['success'] = true;
    $response['message'] = 'Thank you for contacting us! We will get back to you shortly.';

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
} catch (Error $e) {
    $response['success'] = false;
    $response['message'] = 'Server error: ' . $e->getMessage();
}

// Send response
echo json_encode($response);
exit;
