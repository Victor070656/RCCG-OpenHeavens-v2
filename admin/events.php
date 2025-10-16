<?php
/**
 * Events List Page
 * RCCG Open Heavens Parish Admin Panel
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Events Management";
$include_datatables = true; // Include DataTables for listing

// Authentication check
define('AUTH_REQUIRED', true);

// Handle search and filters
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';

// Build query
$query = "SELECT * FROM events WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR location LIKE ? OR description LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if (!empty($status_filter)) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$query .= " ORDER BY start_date DESC";

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
            <li><span class="text-main-600 fw-normal text-15">Events</span></li>
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
                    <h4 class="mb-0">Events Management</h4>
                    <p class="text-gray-600 text-15 mt-4">Manage church events, programs, and activities</p>
                </div>
                <div>
                    <a href="add-event.php" class="btn btn-main rounded-pill py-9">
                        <i class="ph ph-plus-circle me-8"></i>
                        Add New Event
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-24">
        <div class="card-body">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search events..."
                        value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="upcoming" <?php echo $status_filter == 'upcoming' ? 'selected' : ''; ?>>Upcoming
                        </option>
                        <option value="ongoing" <?php echo $status_filter == 'ongoing' ? 'selected' : ''; ?>>Ongoing
                        </option>
                        <option value="completed" <?php echo $status_filter == 'completed' ? 'selected' : ''; ?>>Completed
                        </option>
                        <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Cancelled
                        </option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-main">
                        <i class="ph ph-magnifying-glass me-8"></i>Filter
                    </button>
                    <a href="events.php" class="btn btn-outline-gray">
                        <i class="ph ph-x me-8"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Events</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Entry Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($event = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if ($event['image']): ?>
                                            <img src="<?php echo htmlspecialchars("../uploads/events/" . $event['image']); ?>"
                                                alt="<?php echo htmlspecialchars($event['title']); ?>"
                                                class="w-48 h-48 rounded-8 object-fit-cover">
                                        <?php else: ?>
                                            <div class="w-48 h-48 rounded-8 bg-main-50 flex-center">
                                                <i class="ph ph-calendar text-main-600 text-xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <h6 class="mb-4"><?php echo htmlspecialchars($event['title']); ?></h6>
                                        <p class="text-13 text-gray-600 mb-0">
                                            <?php echo htmlspecialchars(substr($event['description'], 0, 50)) . '...'; ?>
                                        </p>
                                    </td>
                                    <td class="text-gray-600">
                                        <i class="ph ph-map-pin text-gray-400"></i>
                                        <?php echo htmlspecialchars($event['location']); ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <?php echo date('M j, Y', strtotime($event['start_date'])); ?>
                                        <br>
                                        <small class="text-gray-500">
                                            <?php echo date('g:i A', strtotime($event['start_date'])); ?>
                                        </small>
                                    </td>
                                    <td class="text-gray-600">
                                        <?php echo date('M j, Y', strtotime($event['end_date'])); ?>
                                        <br>
                                        <small class="text-gray-500">
                                            <?php echo date('g:i A', strtotime($event['end_date'])); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($event['entry_type'] == 'free'): ?>
                                            <span class="badge bg-success-50 text-success-600">Free</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-50 text-warning-600">
                                                ₦<?php echo number_format($event['entry_fee'], 0); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch ($event['status']) {
                                            case 'upcoming':
                                                $badge_class = 'bg-info-50 text-info-600';
                                                break;
                                            case 'ongoing':
                                                $badge_class = 'bg-success-50 text-success-600';
                                                break;
                                            case 'completed':
                                                $badge_class = 'bg-gray-100 text-gray-600';
                                                break;
                                            case 'cancelled':
                                                $badge_class = 'bg-danger-50 text-danger-600';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucfirst($event['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <a href="edit-event.php?id=<?php echo $event['id']; ?>"
                                                class="btn btn-sm btn-outline-main rounded-pill" title="Edit Event">
                                                <i class="ph ph-pencil"></i>
                                            </a>
                                            <a href="delete-event.php?id=<?php echo $event['id']; ?>"
                                                class="btn btn-sm btn-danger rounded-pill" title="Delete Event"
                                                onclick="return confirmDelete('Are you sure you want to delete this event?');">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-40">
                                    <i class="ph ph-calendar-x text-gray-300 text-5xl mb-12"></i>
                                    <p class="text-gray-400 mb-16">No events found</p>
                                    <a href="add.php" class="btn btn-main btn-sm">
                                        <i class="ph ph-plus-circle me-8"></i>Add Your First Event
                                    </a>
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