<?php
$page_title = "Manage Users - NIST19 Admin Panel";
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
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $role = $_POST['role'] ?? 'admin';
                
                if (!empty($username) && !empty($password)) {
                    try {
                        // Check if username already exists
                        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
                        $stmt->execute([$username]);
                        if ($stmt->fetch()) {
                            $error_message = "Username already exists.";
                        } else {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                            $stmt->execute([$username, $hashed_password, $role]);
                            $success_message = "User created successfully!";
                        }
                    } catch(PDOException $e) {
                        $error_message = "Error creating user: " . $e->getMessage();
                    }
                } else {
                    $error_message = "Username and password are required.";
                }
                break;
                
            case 'update':
                $id = intval($_POST['id'] ?? 0);
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $role = $_POST['role'] ?? 'admin';
                
                if ($id > 0 && !empty($username)) {
                    try {
                        if (!empty($password)) {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
                            $stmt->execute([$username, $hashed_password, $role, $id]);
                        } else {
                            $stmt = $db->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
                            $stmt->execute([$username, $role, $id]);
                        }
                        $success_message = "User updated successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error updating user: " . $e->getMessage();
                    }
                } else {
                    $error_message = "Username is required.";
                }
                break;
                
            case 'delete':
                $id = intval($_POST['id'] ?? 0);
                if ($id > 0) {
                    try {
                        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                        $stmt->execute([$id]);
                        $success_message = "User deleted successfully!";
                    } catch(PDOException $e) {
                        $error_message = "Error deleting user: " . $e->getMessage();
                    }
                }
                break;
        }
    }
}

// Get all users
try {
    $stmt = $db->query("SELECT * FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll();
} catch(PDOException $e) {
    $users = [];
    $error_message = "Error fetching users: " . $e->getMessage();
}
?>

<div class="flex h-screen">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-64 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-users text-gray-500 cursor-pointer"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo count($users); ?></span>
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

        <!-- Action Button -->
        <div class="flex justify-end mb-6">
            <button id="add-user-btn" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New User
            </button>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No users found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $user['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user['username']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo $user['role'] === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $user['role'])); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3 edit-user-btn" 
                                        data-id="<?php echo $user['id']; ?>"
                                        data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                        data-role="<?php echo $user['role']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 delete-user-btn" 
                                        data-id="<?php echo $user['id']; ?>"
                                        data-username="<?php echo htmlspecialchars($user['username']); ?>">
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

<!-- Add/Edit User Modal -->
<div id="user-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4">
        <div class="p-6 border-b">
            <h3 id="modal-title" class="text-lg font-semibold text-gray-800">Add New User</h3>
        </div>
        <form id="user-form" method="POST" action="">
            <div class="p-6 space-y-4">
                <input type="hidden" name="action" id="form-action" value="create">
                <input type="hidden" name="id" id="user-id" value="">
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" id="username" name="username" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1" id="password-help">Required for new users</p>
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select id="role" name="role" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
            </div>
            
            <div class="p-6 border-t flex justify-end space-x-3">
                <button type="button" id="cancel-btn" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save User</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete user "<span id="delete-username"></span>"? This action cannot be undone.</p>
            
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
