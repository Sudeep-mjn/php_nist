<?php
$page_title = "Manage Notices - NIST19 Admin Panel";
include 'includes/header.php';
require_once 'config/database.php';

$db = getDB();
$success_message = '';
$error_message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $date = $_POST['date'] ?? '';
                
                if (!empty($title) && !empty($description) && !empty($date)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO notices (title, description, date, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
                        $stmt->execute([$title, $description, $date]);
                        $success_message = "Notice created successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error creating notice: " . $e->getMessage();
                    }
                } else {
                    $error_message = "All fields are required.";
                }
                break;
                
            case 'update':
                $id = intval($_POST['id'] ?? 0);
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $date = $_POST['date'] ?? '';
                
                if ($id > 0 && !empty($title) && !empty($description) && !empty($date)) {
                    try {
                        $stmt = $db->prepare("UPDATE notices SET title = ?, description = ?, date = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$title, $description, $date, $id]);
                        $success_message = "Notice updated successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error updating notice: " . $e->getMessage();
                    }
                } else {
                    $error_message = "All fields are required.";
                }
                break;
                
            case 'delete':
                $id = intval($_POST['id'] ?? 0);
                if ($id > 0) {
                    try {
                        $stmt = $db->prepare("DELETE FROM notices WHERE id = ?");
                        $stmt->execute([$id]);
                        $success_message = "Notice deleted successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error deleting notice: " . $e->getMessage();
                    }
                }
                break;
        }
    }
}

// Get all notices
try {
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $stmt = $db->prepare("SELECT * FROM notices WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC");
        $stmt->execute(["%$search%", "%$search%"]);
    } else {
        $stmt = $db->query("SELECT * FROM notices ORDER BY created_at DESC");
    }
    $notices = $stmt->fetchAll();
} catch(PDOException $e) {
    $notices = [];
    $error_message = "Error fetching notices: " . $e->getMessage();
}
?>

<div class="flex h-screen">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-64 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Notices</h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-gray-500 cursor-pointer"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo count($notices); ?></span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full mr-2 bg-primary flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <span class="text-gray-700"><?php echo getAdminName(); ?></span>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <?php if ($success_message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <div class="relative w-64">
                <form method="GET" action="">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search notices..." 
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </form>
            </div>
            <button id="add-notice-btn" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Notice
            </button>
        </div>

        <!-- Notices Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($notices)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No notices found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($notices as $notice): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($notice['title']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($notice['description'], 0, 100)) . '...'; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo date('M j, Y', strtotime($notice['date'])); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo date('M j, Y', strtotime($notice['created_at'])); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 edit-notice-btn" 
                                        data-id="<?php echo $notice['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($notice['title']); ?>"
                                        data-description="<?php echo htmlspecialchars($notice['description']); ?>"
                                        data-date="<?php echo $notice['date']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-notice-btn" 
                                        data-id="<?php echo $notice['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($notice['title']); ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Notice Modal -->
<div id="notice-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4">
        <div class="p-6 border-b">
            <h3 id="modal-title" class="text-lg font-semibold text-gray-800">Add New Notice</h3>
        </div>
        <form id="notice-form" method="POST" action="">
            <div class="p-6 space-y-4">
                <input type="hidden" name="action" id="form-action" value="create">
                <input type="hidden" name="id" id="notice-id" value="">
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="title" name="title" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                </div>
                
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" id="date" name="date" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
            
            <div class="p-6 border-t flex justify-end space-x-3">
                <button type="button" id="cancel-btn" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save Notice</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete "<span id="delete-title"></span>"? This action cannot be undone.</p>
            
            <form id="delete-form" method="POST" action="">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete-id" value="">
                
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-delete-btn" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
