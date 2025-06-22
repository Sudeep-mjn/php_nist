<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
$page_title = "Dashboard - NIST19 Admin Panel";
include 'header.php';
require_once 'includes/db.php';

// Count notices
$notices_count = 0;
$activities_count = 0;
$recent_notices = [];
$recent_activities = [];

// Count notices
$result = $conn->query("SELECT COUNT(*) as count FROM notices");
if ($row = $result->fetch_assoc()) {
    $notices_count = $row['count'];
}

// Count activities
// $result = $conn->query("SELECT COUNT(*) as count FROM activities");
// if ($row = $result->fetch_assoc()) {
//     $activities_count = $row['count'];
// }

// Get recent notices
$result = $conn->query("SELECT * FROM notices ORDER BY created_at DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    $recent_notices[] = $row;
}

// Get recent activities
// $result = $conn->query("SELECT * FROM activities ORDER BY created_at DESC LIMIT 5");
// while ($row = $result->fetch_assoc()) {
//     $recent_activities[] = $row;
// }
// ?>

<div class="">
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-64 p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-gray-500 cursor-pointer"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo $notices_count; ?></span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full mr-2 bg-primary flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <span class="text-gray-700"><?php echo getAdminName(); ?></span>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-bell text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Notices</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $notices_count; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-calendar-alt text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Activities</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $activities_count; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <i class="fas fa-users text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Users</p>
                        <p class="text-2xl font-bold text-gray-900">1</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Content</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $notices_count + $activities_count; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Notices -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Notices</h3>
                </div>
                <div class="p-6">
                    <?php if (empty($recent_notices)): ?>
                        <p class="text-gray-500 text-center py-4">No notices found</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($recent_notices as $notice): ?>
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($notice['title'] ?? ''); ?></h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <?php
                                        $desc = $notice['description'] ?? '';
                                        echo htmlspecialchars($desc ? substr($desc, 0, 100) . '...' : 'No description');
                                        ?>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        <?php
                                        $date = $notice['date'] ?? '';
                                        echo $date ? date('M j, Y', strtotime($date)) : 'No date';
                                        ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Activities</h3>
                </div>
                <div class="p-6">
                    <?php if (empty($recent_activities)): ?>
                        <p class="text-gray-500 text-center py-4">No activities found</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($recent_activities as $activity): ?>
                                <div class="border-l-4 border-green-500 pl-4">
                                    <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($activity['title']); ?></h4>
                                    <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars(substr($activity['description'], 0, 100)) . '...'; ?></p>
                                    <p class="text-xs text-gray-400 mt-1"><?php echo date('M j, Y', strtotime($activity['created_at'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
