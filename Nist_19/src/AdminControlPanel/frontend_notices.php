<?php
// Frontend Notices Section - Dynamic content from admin panel
require_once 'config/database.php';

try {
    $db = getDB();
    // Get active notices ordered by date (newest first)
    $stmt = $db->prepare("SELECT * FROM notices WHERE status = 'active' ORDER BY date DESC, created_at DESC LIMIT 10");
    $stmt->execute();
    $notices = $stmt->fetchAll();
} catch(PDOException $e) {
    $notices = [];
}

function truncateText($text, $length = 100) {
    return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}
?>

<div class="notice-container" id="noticeContainer">
    <div class="p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-primary">Latest Notices</h3>
            <button id="closeNotice" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <?php if (empty($notices)): ?>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-secondary">
                    <p class="text-sm text-gray-600">No notices available at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($notices as $notice): ?>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-secondary">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-primary"><?php echo htmlspecialchars($notice['title']); ?></h4>
                        <span class="text-xs text-gray-500"><?php echo date('Y-m-d', strtotime($notice['date'])); ?></span>
                    </div>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars(truncateText($notice['description'], 120)); ?></p>
                    <?php if (strlen($notice['description']) > 120): ?>
                        <a href="#" class="text-secondary text-xs mt-2 inline-block" onclick="showFullNotice('<?php echo htmlspecialchars($notice['title']); ?>', '<?php echo htmlspecialchars($notice['description']); ?>', '<?php echo date('F j, Y', strtotime($notice['date'])); ?>')">Read More →</a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="mt-6 text-center">
            <a href="#" class="text-primary text-sm font-medium hover:underline" onclick="showAllNotices()">View All Notices</a>
        </div>
    </div>
</div>

<!-- Notice Detail Modal -->
<div id="noticeDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 max-w-md mx-4 max-h-screen overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 id="noticeDetailTitle" class="text-lg font-semibold text-primary"></h3>
                <button onclick="closeNoticeDetail()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p id="noticeDetailDate" class="text-sm text-gray-500 mt-1"></p>
        </div>
        <div class="p-6">
            <p id="noticeDetailContent" class="text-gray-700 leading-relaxed"></p>
        </div>
    </div>
</div>

<script>
function showFullNotice(title, content, date) {
    document.getElementById('noticeDetailTitle').textContent = title;
    document.getElementById('noticeDetailContent').textContent = content;
    document.getElementById('noticeDetailDate').textContent = date;
    document.getElementById('noticeDetailModal').classList.remove('hidden');
    document.getElementById('noticeDetailModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeNoticeDetail() {
    document.getElementById('noticeDetailModal').classList.add('hidden');
    document.getElementById('noticeDetailModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function showAllNotices() {
    // You can redirect to a dedicated notices page or expand the current view
    alert('Redirect to full notices page - implement as needed');
}

// Close modal when clicking outside
document.getElementById('noticeDetailModal').addEventListener('click', function(e) {
    if (e.target === this) closeNoticeDetail();
});
</script>