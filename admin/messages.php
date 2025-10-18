<?php
/**
 * Contact Messages Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Contact Messages";

// Authentication check
require_auth();

// Handle status filter
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';

// Build query
$query = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];
$types = "";

if (!empty($status_filter)) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$query .= " ORDER BY created_at DESC";

// Execute query
if (!empty($params)) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}

// Get success/error messages
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

// Include header
include 'includes/header.php';
?>

<!-- Include Sidebar -->
<?php include 'includes/sidebar.php'; ?>

<!-- Include Topbar -->
<?php include 'includes/topbar.php'; ?>

<!-- Main Content Start -->
<div class="dashboard-body">

    <!-- Breadcrumb -->
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-main-600 fw-normal text-15">Contact Messages</span></li>
        </ul>
    </div>

    <!-- Success/Error Messages -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ph ph-check-circle me-2"></i><?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ph ph-x-circle me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="flex-between flex-wrap gap-8">
                <div>
                    <h4 class="mb-0">Contact Messages</h4>
                    <p class="text-gray-600 text-15 mt-4">View and manage messages from your website visitors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-24">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="new" <?php echo $status_filter == 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="read" <?php echo $status_filter == 'read' ? 'selected' : ''; ?>>Read</option>
                        <option value="replied" <?php echo $status_filter == 'replied' ? 'selected' : ''; ?>>Replied</option>
                        <option value="archived" <?php echo $status_filter == 'archived' ? 'selected' : ''; ?>>Archived</option>
                    </select>
                </div>
                <div class="col-md-3 flex-align">
                    <a href="messages.php" class="btn btn-outline-gray">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($message = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($message['name']); ?></h6>
                                        <?php if ($message['phone']): ?>
                                            <p class="text-13 text-gray-600 mb-0">
                                                <i class="ph ph-phone"></i> <?php echo htmlspecialchars($message['phone']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>" class="text-main-600">
                                            <?php echo htmlspecialchars($message['email']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                    <td>
                                        <p class="mb-0 text-truncate" style="max-width: 250px;">
                                            <?php echo htmlspecialchars($message['message']); ?>
                                        </p>
                                    </td>
                                    <td>
                                        <span class="text-13 text-gray-600">
                                            <?php echo date('M j, Y', strtotime($message['created_at'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $status_badge = '';
                                        switch($message['status']) {
                                            case 'new':
                                                $status_badge = 'bg-success-50 text-success-600';
                                                break;
                                            case 'read':
                                                $status_badge = 'bg-info-50 text-info-600';
                                                break;
                                            case 'replied':
                                                $status_badge = 'bg-primary-50 text-primary-600';
                                                break;
                                            case 'archived':
                                                $status_badge = 'bg-gray-100 text-gray-600';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $status_badge; ?>">
                                            <?php echo ucfirst($message['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-40">
                                    <i class="ph ph-envelope-simple text-gray-300 text-5xl mb-12"></i>
                                    <p class="text-gray-400 mb-0">No messages found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- Main Content End -->

<?php
// Include footer
include 'includes/footer.php';
?>
