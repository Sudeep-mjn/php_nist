<?php
$page_title = "Manage Activities - NIST19 Admin Panel";
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
                $link = trim($_POST['link'] ?? '');
                $image_url = '';
                
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (in_array($file_extension, $allowed_extensions)) {
                        $filename = uniqid() . '.' . $file_extension;
                        $upload_path = $upload_dir . $filename;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                            $image_url = $upload_path;
                        }
                    }
                }
                
                if (!empty($title) && !empty($description)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO activities (title, description, image_url, link, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                        $stmt->execute([$title, $description, $image_url, $link]);
                        $success_message = "Activity created successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error creating activity: " . $e->getMessage();
                    }
                } else {
                    $error_message = "Title and description are required.";
                }
                break;
                
            case 'update':
                $id = intval($_POST['id'] ?? 0);
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $link = trim($_POST['link'] ?? '');
                $image_url = $_POST['existing_image'] ?? '';
                
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (in_array($file_extension, $allowed_extensions)) {
                        // Delete old image if exists
                        if (!empty($image_url) && file_exists($image_url)) {
                            unlink($image_url);
                        }
                        
                        $filename = uniqid() . '.' . $file_extension;
                        $upload_path = $upload_dir . $filename;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                            $image_url = $upload_path;
                        }
                    }
                }
                
                if ($id > 0 && !empty($title) && !empty($description)) {
                    try {
                        $stmt = $db->prepare("UPDATE activities SET title = ?, description = ?, image_url = ?, link = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$title, $description, $image_url, $link, $id]);
                        $success_message = "Activity updated successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error updating activity: " . $e->getMessage();
                    }
                } else {
                    $error_message = "Title and description are required.";
                }
                break;
                
            case 'delete':
                $id = intval($_POST['id'] ?? 0);
                if ($id > 0) {
                    try {
                        // Get image URL to delete file
                        $stmt = $db->prepare("SELECT image_url FROM activities WHERE id = ?");
                        $stmt->execute([$id]);
                        $activity = $stmt->fetch();
                        
                        if ($activity && !empty($activity['image_url']) && file_exists($activity['image_url'])) {
                            unlink($activity['image_url']);
                        }
                        
                        $stmt = $db->prepare("DELETE FROM activities WHERE id = ?");
                        $stmt->execute([$id]);
                        $success_message = "Activity deleted successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error deleting activity: " . $e->getMessage();
                    }
                }
                break;
        }
    }
}

// Get all activities
try {
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $stmt = $db->prepare("SELECT * FROM activities WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC");
        $stmt->execute(["%$search%", "%$search%"]);
    } else {
        $stmt = $db->query("SELECT * FROM activities ORDER BY created_at DESC");
    }
    $activities = $stmt->fetchAll();
} catch(PDOException $e) {
    $activities = [];
    $error_message = "Error fetching activities: " . $e->getMessage();
}
?>

<div class="flex h-screen">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-64 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Activities</h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-calendar-alt text-gray-500 cursor-pointer"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo count($activities); ?></span>
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
                           placeholder="Search activities..." 
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </form>
            </div>
            <button id="add-activity-btn" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Activity
            </button>
        </div>

        <!-- Activities Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($activities)): ?>
                <div class="col-span-full text-center py-8">
                    <i class="fas fa-calendar-alt text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No activities found</p>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $activity): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php if (!empty($activity['image_url']) && file_exists($activity['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($activity['image_url']); ?>" alt="Activity Image" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($activity['title']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars(substr($activity['description'], 0, 150)) . '...'; ?></p>
                        
                        <?php if (!empty($activity['link'])): ?>
                            <a href="<?php echo htmlspecialchars($activity['link']); ?>" target="_blank" 
                               class="text-primary hover:text-blue-700 text-sm">
                                <i class="fas fa-external-link-alt mr-1"></i>View Link
                            </a>
                        <?php endif; ?>
                        
                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            <span class="text-xs text-gray-400"><?php echo date('M j, Y', strtotime($activity['created_at'])); ?></span>
                            <div class="space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 edit-activity-btn" 
                                        data-id="<?php echo $activity['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($activity['title']); ?>"
                                        data-description="<?php echo htmlspecialchars($activity['description']); ?>"
                                        data-link="<?php echo htmlspecialchars($activity['link']); ?>"
                                        data-image="<?php echo htmlspecialchars($activity['image_url']); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-activity-btn" 
                                        data-id="<?php echo $activity['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($activity['title']); ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add/Edit Activity Modal -->
<div id="activity-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4 max-h-screen overflow-y-auto">
        <div class="p-6 border-b">
            <h3 id="modal-title" class="text-lg font-semibold text-gray-800">Add New Activity</h3>
        </div>
        <form id="activity-form" method="POST" action="" enctype="multipart/form-data">
            <div class="p-6 space-y-4">
                <input type="hidden" name="action" id="form-action" value="create">
                <input type="hidden" name="id" id="activity-id" value="">
                <input type="hidden" name="existing_image" id="existing-image" value="">
                
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
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Supported formats: JPG, JPEG, PNG, GIF</p>
                </div>
                
                <div>
                    <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Link (Optional)</label>
                    <input type="url" id="link" name="link" placeholder="https://example.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
            
            <div class="p-6 border-t flex justify-end space-x-3">
                <button type="button" id="cancel-btn" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save Activity</button>
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
