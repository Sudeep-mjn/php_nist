<?php
$page_title = "Profile - NIST19 Admin Panel";
include 'includes/header.php';

$success_message = '';
$error_message = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // For demo purposes with hardcoded credentials
    if ($current_password === 'Admin@1') {
        if (!empty($new_password) && $new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $success_message = "Password updated successfully! (Note: This is a demo - actual password change not implemented)";
            } else {
                $error_message = "New password must be at least 6 characters long.";
            }
        } else {
            $error_message = "New passwords do not match.";
        }
    } else {
        $error_message = "Current password is incorrect.";
    }
}
?>

<div class="flex h-screen">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-64 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Profile Settings</h1>
            <div class="flex items-center space-x-4">
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

        <div class="max-w-2xl">
            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Profile Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-primary flex items-center justify-center mr-6">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800"><?php echo getAdminName(); ?></h4>
                            <p class="text-gray-600"><?php echo getAdminEmail(); ?></p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                                Administrator
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" value="<?php echo getAdminEmail(); ?>" disabled
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <input type="text" value="Administrator" disabled
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Change Password</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="">
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" id="current_password" name="current_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" id="new_password" name="new_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Account Statistics</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary"><?php echo date('Y-m-d'); ?></div>
                            <div class="text-sm text-gray-600">Last Login</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">Active</div>
                            <div class="text-sm text-gray-600">Account Status</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">Admin</div>
                            <div class="text-sm text-gray-600">Access Level</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
