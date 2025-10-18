<?php
/**
 * Dashboard Page
 * RCCG Open Heavens Parish Admin Panel
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Dashboard";
$include_charts = true; // Include chart library for statistics

// Authentication check
define('AUTH_REQUIRED', true);

// Get statistics from database
$stats = [
    'total_members' => 0,
    'upcoming_events' => 0,
    'published_sermons' => 0,
    'new_messages' => 0
];

// Get total members count
$result = $conn->query("SELECT COUNT(*) as count FROM members WHERE status = 'active'");
if ($result) {
    $stats['total_members'] = $result->fetch_assoc()['count'];
}

// Get upcoming events count
$result = $conn->query("SELECT COUNT(*) as count FROM events WHERE status = 'upcoming' AND `start_date` > NOW()");
if ($result) {
    $stats['upcoming_events'] = $result->fetch_assoc()['count'];
}

// Get published sermons count
$result = $conn->query("SELECT COUNT(*) as count FROM sermons WHERE status = 'published'");
if ($result) {
    $stats['published_sermons'] = $result->fetch_assoc()['count'];
}

// Get new messages count
$result = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'");
if ($result) {
    $stats['new_messages'] = $result->fetch_assoc()['count'];
}

// Get recent events
$recent_events_query = "SELECT * FROM events ORDER BY created_at DESC LIMIT 5";
$recent_events = $conn->query($recent_events_query);

// Get recent sermons
$recent_sermons_query = "SELECT * FROM sermons WHERE status = 'published' ORDER BY sermon_date DESC LIMIT 5";
$recent_sermons = $conn->query($recent_sermons_query);

// Include header
include 'includes/header.php';
?>

<!-- Include Sidebar -->
<?php include 'includes/sidebar.php'; ?>

<!-- Include Topbar -->
<?php include 'includes/topbar.php'; ?>

<!-- Main Content Start -->
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons flex-between flex-wrap gap-8 mb-24">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Dashboard</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->
    </div>

    <!-- Welcome Message -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="flex-between flex-wrap gap-8">
                <div>
                    <h4 class="mb-8">Welcome back, <?php echo htmlspecialchars($current_admin['full_name']); ?>! 👋</h4>
                    <p class="text-gray-600 text-15">Here's what's happening with your church today.</p>
                </div>
                <div class="flex-align gap-8">
                    <span class="text-gray-600 text-15">Last login: <?php echo date('F j, Y g:i A'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row gy-4 mb-24">
        <!-- Total Members Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-between gap-8 mb-24">
                        <span
                            class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl">
                            <i class="ph ph-users-three"></i>
                        </span>
                        <div id="member-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>
                    <h4 class="mb-2"><?php echo number_format($stats['total_members']); ?></h4>
                    <span class="text-gray-600 text-sm">Total Members</span>
                    <p class="text-sm mb-0 mt-8">
                        <a href="members.php" class="text-main-600 hover-text-decoration-underline">View all members</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-between gap-8 mb-24">
                        <span
                            class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl">
                            <i class="ph ph-calendar-dots"></i>
                        </span>
                        <div id="event-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>
                    <h4 class="mb-2"><?php echo number_format($stats['upcoming_events']); ?></h4>
                    <span class="text-gray-600 text-sm">Upcoming Events</span>
                    <p class="text-sm mb-0 mt-8">
                        <a href="events.php" class="text-main-600 hover-text-decoration-underline">View all events</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Published Sermons Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-between gap-8 mb-24">
                        <span
                            class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-success-600 text-white text-2xl">
                            <i class="ph ph-book-open"></i>
                        </span>
                        <div id="sermon-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>
                    <h4 class="mb-2"><?php echo number_format($stats['published_sermons']); ?></h4>
                    <span class="text-gray-600 text-sm">Published Sermons</span>
                    <p class="text-sm mb-0 mt-8">
                        <a href="sermons.php" class="text-main-600 hover-text-decoration-underline">View all sermons</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- New Messages Card -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-between gap-8 mb-24">
                        <span
                            class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl">
                            <i class="ph ph-envelope"></i>
                        </span>
                        <div id="message-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>
                    <h4 class="mb-2"><?php echo number_format($stats['new_messages']); ?></h4>
                    <span class="text-gray-600 text-sm">New Messages</span>
                    <p class="text-sm mb-0 mt-8">
                        <a href="messages.php" class="text-main-600 hover-text-decoration-underline">View all
                            messages</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events and Sermons -->
    <div class="row gy-4">
        <!-- Recent Events -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Recent Events</h5>
                        <a href="events.php" class="text-main-600 text-sm hover-text-decoration-underline">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($recent_events && $recent_events->num_rows > 0): ?>
                        <div class="max-h-350 overflow-y-auto scroll-sm">
                            <?php while ($event = $recent_events->fetch_assoc()): ?>
                                <div class="d-flex align-items-start gap-12 mb-16 pb-16 border-bottom border-gray-100">
                                    <span class="flex-shrink-0 w-40 h-40 flex-center rounded-circle bg-main-50 text-main-600">
                                        <i class="ph ph-calendar text-xl"></i>
                                    </span>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-4">
                                            <a href="edit-event.php?id=<?php echo $event['id']; ?>"
                                                class="text-gray-900 hover-text-main-600">
                                                <?php echo htmlspecialchars($event['title']); ?>
                                            </a>
                                        </h6>
                                        <p class="text-13 text-gray-600 mb-4">
                                            <?php echo htmlspecialchars(substr($event['description'], 0, 80)) . '...'; ?>
                                        </p>
                                        <div class="flex-align gap-12">
                                            <span class="text-xs text-gray-500">
                                                <i class="ph ph-clock"></i>
                                                <?php echo date('M j, Y', strtotime($event['start_date'])); ?>
                                            </span>
                                            <span class="badge <?php
                                            echo $event['status'] == 'upcoming' ? 'bg-success-50 text-success-600' :
                                                ($event['status'] == 'ongoing' ? 'bg-warning-50 text-warning-600' :
                                                    'bg-gray-100 text-gray-600');
                                            ?>">
                                                <?php echo ucfirst($event['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-40">
                            <i class="ph ph-calendar-x text-gray-300 text-5xl mb-12"></i>
                            <p class="text-gray-400">No events found</p>
                            <a href="add-event.php" class="btn btn-main btn-sm mt-12">Add New Event</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Sermons -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Recent Sermons</h5>
                        <a href="sermons.php" class="text-main-600 text-sm hover-text-decoration-underline">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($recent_sermons && $recent_sermons->num_rows > 0): ?>
                        <div class="max-h-350 overflow-y-auto scroll-sm">
                            <?php while ($sermon = $recent_sermons->fetch_assoc()): ?>
                                <div class="d-flex align-items-start gap-12 mb-16 pb-16 border-bottom border-gray-100">
                                    <span
                                        class="flex-shrink-0 w-40 h-40 flex-center rounded-circle bg-purple-50 text-purple-600">
                                        <i class="ph ph-book-open text-xl"></i>
                                    </span>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-4">
                                            <a href="edit-sermon.php?id=<?php echo $sermon['id']; ?>"
                                                class="text-gray-900 hover-text-main-600">
                                                <?php echo htmlspecialchars($sermon['title']); ?>
                                            </a>
                                        </h6>
                                        <p class="text-13 text-gray-600 mb-4">
                                            Pastor: <?php echo htmlspecialchars($sermon['pastor']); ?>
                                        </p>
                                        <div class="flex-align gap-12">
                                            <span class="text-xs text-gray-500">
                                                <i class="ph ph-calendar"></i>
                                                <?php echo date('M j, Y', strtotime($sermon['sermon_date'])); ?>
                                            </span>
                                            <?php if ($sermon['category']): ?>
                                                <span class="badge bg-main-50 text-main-600">
                                                    <?php echo htmlspecialchars($sermon['category']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-40">
                            <i class="ph ph-book-open text-gray-300 text-5xl mb-12"></i>
                            <p class="text-gray-400">No sermons found</p>
                            <a href="add-sermon.php" class="btn btn-main btn-sm mt-12">Add New Sermon</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mt-24">
        <div class="card-header">
            <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <a href="add-event.php" class="btn btn-outline-main w-100 py-12">
                        <i class="ph ph-plus-circle me-8"></i>
                        Add New Event
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="add-sermon.php" class="btn btn-outline-main w-100 py-12">
                        <i class="ph ph-plus-circle me-8"></i>
                        Add New Sermon
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="add-member.php" class="btn btn-outline-main w-100 py-12">
                        <i class="ph ph-plus-circle me-8"></i>
                        Add New Member
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="messages.php" class="btn btn-outline-main w-100 py-12">
                        <i class="ph ph-envelope me-8"></i>
                        View Messages
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Main Content End -->

<?php
// Include footer
// include 'includes/footer.php';
?>