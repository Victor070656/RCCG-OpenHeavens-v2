<?php
/**
 * Members List Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Members Management";
$include_datatables = true; // Include DataTables for listing

// Authentication check
define('AUTH_REQUIRED', true);

// Handle search and filters
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';
$membership_type_filter = isset($_GET['membership_type']) ? sanitize_input($_GET['membership_type']) : '';
$department_filter = isset($_GET['department']) ? sanitize_input($_GET['department']) : '';

// Build query
$query = "SELECT * FROM members WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ssss";
}

if (!empty($status_filter)) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if (!empty($membership_type_filter)) {
    $query .= " AND membership_type = ?";
    $params[] = $membership_type_filter;
    $types .= "s";
}

if (!empty($department_filter)) {
    $query .= " AND department = ?";
    $params[] = $department_filter;
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

// Get unique departments for filter
$departments_result = $conn->query("SELECT DISTINCT department FROM members WHERE department IS NOT NULL AND department != '' ORDER BY department");

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
            <li><span class="text-main-600 fw-normal text-15">Members</span></li>
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
                    <h4 class="mb-0">Members Management</h4>
                    <p class="text-gray-600 text-15 mt-4">Manage church members and their information</p>
                </div>
                <div>
                    <a href="add-member.php" class="btn btn-main rounded-pill py-9">
                        <i class="ph ph-plus-circle me-8"></i>
                        Add New Member
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
                           placeholder="Search members..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" <?php echo $status_filter == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $status_filter == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="membership_type" class="form-label">Membership Type</label>
                    <select class="form-select" id="membership_type" name="membership_type">
                        <option value="">All Types</option>
                        <option value="full_member" <?php echo $membership_type_filter == 'full_member' ? 'selected' : ''; ?>>Full Member</option>
                        <option value="associate_member" <?php echo $membership_type_filter == 'associate_member' ? 'selected' : ''; ?>>Associate Member</option>
                        <option value="visitor" <?php echo $membership_type_filter == 'visitor' ? 'selected' : ''; ?>>Visitor</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-select" id="department" name="department">
                        <option value="">All Departments</option>
                        <?php while ($dept = $departments_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($dept['department']); ?>"
                                    <?php echo $department_filter == $dept['department'] ? 'selected' : ''; ?> >
                                <?php echo htmlspecialchars($dept['department']); ?>
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

    <!-- Members Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Members</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Membership</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($member = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-dark">
                                        <?php if ($member['photo']): ?>
                                            <img src="<?php echo htmlspecialchars($member['photo']); ?>"
                                                 alt="<?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>"
                                                 class="w-48 h-48 rounded-circle object-fit-cover">
                                        <?php else: ?>
                                            <div class="w-48 h-48 rounded-circle bg-main-50 flex-center">
                                                <i class="ph ph-user text-main-600 text-xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-dark">
                                        <h6 class="mb-4">
                                            <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                                        </h6>
                                        <?php if ($member['date_of_birth']): ?>
                                            <p class="text-13 text-gray-600 mb-0">
                                                <i class="ph ph-cake"></i>
                                                <?php echo date('M j, Y', strtotime($member['date_of_birth'])); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-dark">
                                        <?php if ($member['email']): ?>
                                            <p class="text-13 mb-4">
                                                <i class="ph ph-envelope text-gray-400"></i>
                                                <?php echo htmlspecialchars($member['email']); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($member['phone']): ?>
                                            <p class="text-13 mb-0">
                                                <i class="ph ph-phone text-gray-400"></i>
                                                <?php echo htmlspecialchars($member['phone']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $type_badge = '';
                                        switch($member['membership_type']) {
                                            case 'full_member':
                                                $type_badge = 'bg-success-50 text-success-600';
                                                $type_text = 'Full Member';
                                                break;
                                            case 'associate_member':
                                                $type_badge = 'bg-info-50 text-info-600';
                                                $type_text = 'Associate Member';
                                                break;
                                            case 'visitor':
                                                $type_badge = 'bg-warning-50 text-warning-600';
                                                $type_text = 'Visitor';
                                                break;
                                            default:
                                                $type_badge = 'bg-gray-100 text-gray-600';
                                                $type_text = ucfirst($member['membership_type']);
                                        }
                                        ?>
                                        <span class="badge <?php echo $type_badge; ?>">
                                            <?php echo $type_text; ?>
                                        </span>
                                        <?php if ($member['membership_date']): ?>
                                            <p class="text-xs text-gray-500 mt-4 mb-0">
                                                Since <?php echo date('M Y', strtotime($member['membership_date'])); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($member['department']): ?>
                                            <span class="badge bg-main-50 text-main-600">
                                                <?php echo htmlspecialchars($member['department']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $status_badge = $member['status'] == 'active'
                                            ? 'bg-success-50 text-success-600'
                                            : 'bg-gray-100 text-gray-600';
                                        ?>
                                        <span class="badge <?php echo $status_badge; ?>">
                                            <?php echo ucfirst($member['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex-align gap-8">
                                            <a href="edit-member.php?id=<?php echo $member['id']; ?>"
                                               class="btn btn-sm btn-outline-main rounded-pill"
                                               title="Edit Member">
                                                <i class="ph ph-pencil"></i>
                                            </a>
                                            <a href="delete-member.php?id=<?php echo $member['id']; ?>"
                                               class="btn btn-sm btn-danger rounded-pill"
                                               title="Delete Member"
                                               onclick="return confirm('Are you sure you want to delete this member?');">
                                                <i class="ph ph-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-40">
                                    <i class="ph ph-users-three text-gray-300 text-5xl mb-12"></i>
                                    <p class="text-gray-400 mb-16">No members found</p>
                                    <a href="add-member.php" class="btn btn-main btn-sm">
                                        <i class="ph ph-plus-circle me-8"></i>Add Your First Member
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
