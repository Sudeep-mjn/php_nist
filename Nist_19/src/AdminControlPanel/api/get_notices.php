<?php
// API endpoint to get notices for frontend
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

try {
    $db = getDB();
    
    // Get limit parameter (default 10)
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $limit = min($limit, 50); // Maximum 50 notices
    
    // Get status filter (default active only)
    $status = isset($_GET['status']) ? $_GET['status'] : 'active';
    
    if ($status === 'all') {
        $stmt = $db->prepare("SELECT id, title, description, date, status, created_at FROM notices ORDER BY date DESC, created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
    } else {
        $stmt = $db->prepare("SELECT id, title, description, date, status, created_at FROM notices WHERE status = ? ORDER BY date DESC, created_at DESC LIMIT ?");
        $stmt->execute([$status, $limit]);
    }
    
    $notices = $stmt->fetchAll();
    
    // Format the response
    $response = [
        'success' => true,
        'count' => count($notices),
        'data' => $notices
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