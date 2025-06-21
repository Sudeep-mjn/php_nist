<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIST19 Frontend Demo - Dynamic Content</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#37517E',
                        'secondary': '#FF6B6B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary mb-4">NIST19 Frontend Demo</h1>
            <p class="text-gray-600">Live content from admin panel - notices and activities</p>
            <div class="mt-4">
                <a href="/" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 mr-4">Go to Admin Panel</a>
                <button onclick="location.reload()" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-red-500">Refresh Content</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Notices Section -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-bold text-primary">Notices Section</h2>
                    <p class="text-sm text-gray-600">Content managed through admin panel</p>
                </div>
                <?php include 'frontend_notices.php'; ?>
            </div>

            <!-- Activities Section Preview -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-bold text-primary">Activities Section Preview</h2>
                    <p class="text-sm text-gray-600">First 3 activities from admin panel</p>
                </div>
                <div class="p-4">
                    <?php
                    require_once 'config/database.php';
                    try {
                        $db = getDB();
                        $stmt = $db->prepare("SELECT * FROM activities WHERE status = 'active' ORDER BY created_at DESC LIMIT 3");
                        $stmt->execute();
                        $preview_activities = $stmt->fetchAll();
                    } catch(PDOException $e) {
                        $preview_activities = [];
                    }
                    ?>
                    
                    <div class="space-y-4">
                        <?php if (empty($preview_activities)): ?>
                            <p class="text-gray-500 text-center py-4">No activities available</p>
                        <?php else: ?>
                            <?php foreach ($preview_activities as $activity): ?>
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start space-x-4">
                                    <?php if (!empty($activity['image_url']) && file_exists($activity['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($activity['image_url']); ?>" alt="<?php echo htmlspecialchars($activity['title']); ?>" class="w-16 h-16 object-cover rounded">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-primary"><?php echo htmlspecialchars($activity['title']); ?></h4>
                                        <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars(substr($activity['description'], 0, 80)) . '...'; ?></p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($activity['created_at'])); ?></span>
                                            <?php if (!empty($activity['link'])): ?>
                                                <a href="<?php echo htmlspecialchars($activity['link']); ?>" target="_blank" class="text-secondary text-xs hover:underline">Read More</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Activities Section -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-lg p-4 mb-4">
                <h2 class="text-xl font-bold text-primary mb-2">Full Activities Section</h2>
                <p class="text-sm text-gray-600">Complete activities section as it would appear on your website</p>
            </div>
            <?php include 'frontend_activities.php'; ?>
        </div>

        <!-- API Information -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-primary mb-4">API Endpoints Available</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded border">
                    <h4 class="font-semibold text-gray-800">Notices API</h4>
                    <p class="text-sm text-gray-600 mt-1">GET /api/get_notices.php</p>
                    <p class="text-xs text-gray-500 mt-2">Parameters: limit, status</p>
                    <a href="api/get_notices.php?limit=5" target="_blank" class="text-primary text-sm hover:underline">Test API →</a>
                </div>
                <div class="bg-white p-4 rounded border">
                    <h4 class="font-semibold text-gray-800">Activities API</h4>
                    <p class="text-sm text-gray-600 mt-1">GET /api/get_activities.php</p>
                    <p class="text-xs text-gray-500 mt-2">Parameters: limit, status</p>
                    <a href="api/get_activities.php?limit=3" target="_blank" class="text-primary text-sm hover:underline">Test API →</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>