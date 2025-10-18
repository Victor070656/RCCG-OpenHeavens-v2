<?php
/**
 * Delete Member Handler
 * RCCG Open Heavens Parish Admin Panel
 */
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Authentication check
require_auth();

// Get member ID
$member_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($member_id <= 0) {
    header('Location: members.php?error=' . urlencode('Invalid member ID'));
    exit();
}

// Fetch member to get photo URL
$stmt = $conn->prepare("SELECT photo FROM members WHERE id = ?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: members.php?error=' . urlencode('Member not found'));
    exit();
}

$member = $result->fetch_assoc();
$stmt->close();

// Delete the member from database
$stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
$stmt->bind_param("i", $member_id);

if ($stmt->execute()) {
    // Delete associated photo file if exists
    if (!empty($member['photo']) && file_exists('../../' . $member['photo'])) {
        unlink('../../' . $member['photo']);
    }

    header('Location: members.php?success=' . urlencode('Member deleted successfully'));
} else {
    header('Location: members.php?error=' . urlencode('Failed to delete member'));
}

$stmt->close();
exit();
?>