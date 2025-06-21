<?php
// Frontend Activities Section - Dynamic content from admin panel
require_once 'config/database.php';

try {
    $db = getDB();
    // Get active activities ordered by creation date (newest first)
    $stmt = $db->prepare("SELECT * FROM activities WHERE status = 'active' ORDER BY created_at DESC LIMIT 6");
    $stmt->execute();
    $activities = $stmt->fetchAll();
} catch(PDOException $e) {
    $activities = [];
}

function truncateDescription($text, $length = 80) {
    return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}
?>

<!-- Our Activity -->
<section id="activities" class="py-16 bg-primary dark:bg-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4 dark:text-white">Our Activities</h2>
            <p class="text-lg text-white max-w-3xl mx-auto dark:text-gray-300">Engaging with our community and sharing knowledge about stock market investments.</p>
        </div>
                
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($activities)): ?>
                <div class="col-span-full text-center text-white">
                    <p>No activities available at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $activity): ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300 dark:bg-gray-800">
                    <?php if (!empty($activity['image_url']) && file_exists($activity['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($activity['image_url']); ?>" alt="<?php echo htmlspecialchars($activity['title']); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-primary mb-2 dark:text-white"><?php echo htmlspecialchars($activity['title']); ?></h3>
                        <p class="text-gray-600 mb-4 dark:text-gray-300"><?php echo htmlspecialchars(truncateDescription($activity['description'])); ?></p>
                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                            <span><i class="far fa-calendar-alt mr-1"></i> <?php echo date('j F Y', strtotime($activity['created_at'])); ?></span>
                            <?php if (!empty($activity['link'])): ?>
                                <a href="<?php echo htmlspecialchars($activity['link']); ?>" target="_blank" class="text-secondary hover:text-primary">Read More</a>
                            <?php else: ?>
                                <a href="#" onclick="showActivityDetail('<?php echo htmlspecialchars($activity['title']); ?>', '<?php echo htmlspecialchars($activity['description']); ?>', '<?php echo date('F j, Y', strtotime($activity['created_at'])); ?>', '<?php echo htmlspecialchars($activity['image_url'] ?? ''); ?>')" class="text-secondary hover:text-primary">Read More</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Activity Detail Modal -->
<div id="activityDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4 max-h-screen overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 id="activityDetailTitle" class="text-lg font-semibold text-primary"></h3>
                <button onclick="closeActivityDetail()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p id="activityDetailDate" class="text-sm text-gray-500 mt-1"></p>
        </div>
        <div id="activityDetailImage" class="hidden">
            <img id="activityDetailImg" src="" alt="" class="w-full h-48 object-cover">
        </div>
        <div class="p-6">
            <p id="activityDetailContent" class="text-gray-700 leading-relaxed"></p>
        </div>
    </div>
</div>

<script>
function showActivityDetail(title, content, date, image) {
    document.getElementById('activityDetailTitle').textContent = title;
    document.getElementById('activityDetailContent').textContent = content;
    document.getElementById('activityDetailDate').textContent = date;
    
    if (image && image.trim() !== '') {
        document.getElementById('activityDetailImg').src = image;
        document.getElementById('activityDetailImg').alt = title;
        document.getElementById('activityDetailImage').classList.remove('hidden');
    } else {
        document.getElementById('activityDetailImage').classList.add('hidden');
    }
    
    document.getElementById('activityDetailModal').classList.remove('hidden');
    document.getElementById('activityDetailModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeActivityDetail() {
    document.getElementById('activityDetailModal').classList.add('hidden');
    document.getElementById('activityDetailModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('activityDetailModal').addEventListener('click', function(e) {
    if (e.target === this) closeActivityDetail();
});
</script>