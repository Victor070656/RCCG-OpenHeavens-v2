<?php
/**
 * Delete Event Handler
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once '../config/db.php';
require_once '../config/auth.php';

// Authentication check
require_auth();

// Get event ID
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id <= 0) {
    header('Location: index.php?error=' . urlencode('Invalid event ID'));
    exit();
}

// Fetch event to get image URL
$stmt = $conn->prepare("SELECT image_url FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php?error=' . urlencode('Event not found'));
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Delete the event from database
$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);

if ($stmt->execute()) {
    // Delete associated image file if exists
    if (!empty($event['image_url']) && file_exists('../../' . $event['image_url'])) {
        unlink('../../' . $event['image_url']);
    }

    header('Location: index.php?success=' . urlencode('Event deleted successfully'));
} else {
    header('Location: index.php?error=' . urlencode('Failed to delete event'));
}

$stmt->close();
exit();
?>
