<?php
/**
 * Sermons List Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Sermons Management";
$include_datatables = true; // Include DataTables for listing

// Authentication check
define('AUTH_REQUIRED', true);

// Handle search and filters
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';
$category_filter = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';

// Build query
$query = "SELECT * FROM sermons WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR pastor LIKE ? OR scripture_reference LIKE ?)";
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

if (!empty($category_filter)) {
    $query .= " AND category = ?";
    $params[] = $category_filter;
    $types .= "s";
}

$query .= " ORDER BY sermon_date DESC";

// Execute query
if (!empty($params)) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}

// Get unique categories for filter
$categories_result = $conn->query("SELECT DISTINCT category FROM sermons WHERE category IS NOT NULL AND category != '' ORDER BY category");

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
            <li><span class="text-main-600 fw-normal text-15">Sermons</span></li>
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
                    <h4 class="mb-0">Sermons Management</h4>
                    <p class="text-gray-600 text-15 mt-4">Manage church sermons, messages, and teachings</p>
                </div>
                <div>
                    <a href="add.php" class="btn btn-main rounded-pill py-9">
                        <i class="ph ph-plus-circle me-8"></i>
                        Add New Sermon
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-24">
        <div class="card-body">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search"
                           placeholder="Search sermons..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="published" <?php echo $status_filter == 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?php echo $status_filter == 'draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="archived" <?php echo $status_filter == 'archived' ? 'selected' : ''; ?>>Archived</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        <?php while ($cat = $categories_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>"
                                    <?php echo $category_filter == $cat['category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-main">
                        <i class="ph ph-magnifying-glass me-8"></i>Filter
                    </button>
                    <a href="index.php" class="btn btn-outline-gray">
                        <i class="ph ph-x me-8"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sermons Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Sermons</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Pastor</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Media</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($sermon = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if ($sermon['thumbnail_url']): ?>
                                            <img src="<?php echo htmlspecialchars($sermon['thumbnail_url']); ?>"
                                                 alt="<?php echo htmlspecialchars($sermon['title']); ?>"
                                                 class="w-48 h-48 rounded-8 object-fit-cover">
                                        <?php else: ?>
                                            <div class="w-48 h-48 rounded-8 bg-purple-50 flex-center">
                                                <i class="ph ph-book-open text-purple-600 text-xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <h6 class="mb-4"><?php echo htmlspecialchars($sermon['title']); ?></h6>
                                        <?php if ($sermon['scripture_reference']): ?>
                                            <p class="text-13 text-gray-600 mb-0">
                                                <i class="ph ph-book"></i>
                                                <?php echo htmlspecialchars($sermon['scripture_reference']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <i class="ph ph-user text-gray-400"></i>
                                        <?php echo htmlspecialchars($sermon['pastor']); ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <?php echo date('M j, Y', strtotime($sermon['sermon_date'])); ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <?php if ($sermon['category']): ?>
                                            <span class="badge bg-main-50 text-main-600">
                                                <?php echo htmlspecialchars($sermon['category']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-gray-600">
                                        <div class="flex-align gap-4">
                                            <?php if ($sermon['video_url']): ?>
                                                <span class="badge bg-danger-50 text-danger-600" title="Has Video">
                                                    <i class="ph ph-video-camera"></i>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($sermon['audio_url']): ?>
                                                <span class="badge bg-success-50 text-success-600" title="Has Audio">
                                                    <i class="ph ph-microphone"></i>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (!$sermon['video_url'] && !$sermon['audio_url']): ?>
                                                <span class="text-gray-400">-</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($sermon['status']) {
                                            case 'published':
                                                $badge_class = 'bg-success-50 text-success-600';
                                                break;
                                            case 'draft':
                                                $badge_class = 'bg-warning-50 text-warning-600';
                                                break;
                                            case 'archived':
                                                $badge_class = 'bg-gray-100 text-gray-600';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucfirst($sermon['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <a href="edit-sermon.php?id=<?php echo $sermon['id']; ?>"
                                               class="btn btn-sm btn-outline-main rounded-pill"
                                               title="Edit Sermon">
                                                <i class="ph ph-pencil"></i>
                                            </a>
                                            <a href="delete-sermon.php?id=<?php echo $sermon['id']; ?>"
                                               class="btn btn-sm btn-danger rounded-pill"
                                               title="Delete Sermon"
                                               onclick="return confirmDelete('Are you sure you want to delete this sermon?');">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-40">
                                    <i class="ph ph-book-open text-gray-300 text-5xl mb-12"></i>
                                    <p class="text-gray-400 mb-16">No sermons found</p>
                                    <a href="add.php" class="btn btn-main btn-sm">
                                        <i class="ph ph-plus-circle me-8"></i>Add Your First Sermon
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
