<?php
/**
 * Delete Sermon Handler
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Authentication check
require_auth();

// Get sermon ID
$sermon_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($sermon_id <= 0) {
    header('Location: sermons.php?error=' . urlencode('Invalid sermon ID'));
    exit();
}

// Fetch sermon to get thumbnail URL
$stmt = $conn->prepare("SELECT thumbnail FROM sermons WHERE id = ?");
$stmt->bind_param("i", $sermon_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: sermons.php?error=' . urlencode('Sermon not found'));
    exit();
}

$sermon = $result->fetch_assoc();
$stmt->close();

// Delete the sermon from database
$stmt = $conn->prepare("DELETE FROM sermons WHERE id = ?");
$stmt->bind_param("i", $sermon_id);

if ($stmt->execute()) {
    // Delete associated thumbnail file if exists
    if (!empty($sermon['thumbnail']) && file_exists('../uploads/sermons/' . $sermon['thumbnail_url'])) {
        unlink('../uploads/sermons/' . $sermon['thumbnail_url']);
    }

    header('Location: sermons.php?success=' . urlencode('Sermon deleted successfully'));
} else {
    header('Location: sermons.php?error=' . urlencode('Failed to delete sermon'));
}

$stmt->close();
exit();
?>
