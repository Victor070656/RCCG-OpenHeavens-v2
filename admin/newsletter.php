<?php
/**
 * Newsletter Subscriptions Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Newsletter Subscriptions";

// Authentication check
require_auth();

// Handle status filter
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';

// Build query
$query = "SELECT * FROM newsletter_subscriptions WHERE 1=1";
$params = [];
$types = "";

if (!empty($status_filter)) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$query .= " ORDER BY subscribed_at DESC";

// Execute query
if (!empty($params)) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}

// Get statistics
$total_subscribers = $conn->query("SELECT COUNT(*) as count FROM newsletter_subscriptions WHERE status = 'active'")->fetch_assoc()['count'];
$total_unsubscribed = $conn->query("SELECT COUNT(*) as count FROM newsletter_subscriptions WHERE status = 'unsubscribed'")->fetch_assoc()['count'];

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
            <li><span class="text-main-600 fw-normal text-15">Newsletter Subscriptions</span></li>
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
                    <h4 class="mb-0">Newsletter Subscriptions</h4>
                    <p class="text-gray-600 text-15 mt-4">Manage your newsletter subscribers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row gy-4 mb-24">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-between gap-8">
                        <div>
                            <h3 class="mb-2"><?php echo number_format($total_subscribers); ?></h3>
                            <span class="text-gray-600 text-sm">Active Subscribers</span>
                        </div>
                        <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-success-50 text-success-600 text-2xl">
                            <i class="ph ph-check-circle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-between gap-8">
                        <div>
                            <h3 class="mb-2"><?php echo number_format($total_unsubscribed); ?></h3>
                            <span class="text-gray-600 text-sm">Unsubscribed</span>
                        </div>
                        <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-gray-100 text-gray-600 text-2xl">
                            <i class="ph ph-x-circle"></i>
                        </span>
                    </div>
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
                        <option value="active" <?php echo $status_filter == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="unsubscribed" <?php echo $status_filter == 'unsubscribed' ? 'selected' : ''; ?>>Unsubscribed</option>
                    </select>
                </div>
                <div class="col-md-3 flex-align">
                    <a href="newsletter.php" class="btn btn-outline-gray">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscribers List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email Address</th>
                            <th>Subscribed Date</th>
                            <th>Status</th>
                            <th>Unsubscribed Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $counter = 1; ?>
                            <?php while ($subscriber = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($subscriber['email']); ?>" class="text-main-600">
                                            <i class="ph ph-envelope me-8"></i><?php echo htmlspecialchars($subscriber['email']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-13 text-gray-600">
                                            <?php echo date('M j, Y g:i A', strtotime($subscriber['subscribed_at'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $subscriber['status'] == 'active' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-600'; ?>">
                                            <?php echo ucfirst($subscriber['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($subscriber['unsubscribed_at']): ?>
                                            <span class="text-13 text-gray-600">
                                                <?php echo date('M j, Y g:i A', strtotime($subscriber['unsubscribed_at'])); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-40">
                                    <i class="ph ph-newspaper text-gray-300 text-5xl mb-12"></i>
                                    <p class="text-gray-400 mb-0">No subscribers found</p>
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
