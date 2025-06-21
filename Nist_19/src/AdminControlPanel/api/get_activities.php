<?php
// API endpoint to get activities for frontend
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

try {
    $db = getDB();
    
    // Get limit parameter (default 6)
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 6;
    $limit = min($limit, 50); // Maximum 50 activities
    
    // Get status filter (default active only)
    $status = isset($_GET['status']) ? $_GET['status'] : 'active';
    
    if ($status === 'all') {
        $stmt = $db->prepare("SELECT id, title, description, image_url, link, status, created_at FROM activities ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
    } else {
        $stmt = $db->prepare("SELECT id, title, description, image_url, link, status, created_at FROM activities WHERE status = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$status, $limit]);
    }
    
    $activities = $stmt->fetchAll();
    
    // Format the response
    $response = [
        'success' => true,
        'count' => count($activities),
        'data' => $activities
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
?>