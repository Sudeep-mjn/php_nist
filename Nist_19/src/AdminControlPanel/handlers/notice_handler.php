<?php
require_once '../config/database.php';
require_once '../config/auth.php';

// Ensure user is authenticated
requireAuth();

header('Content-Type: application/json');

$db = getDB();
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'get':
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                try {
                    $stmt = $db->prepare("SELECT * FROM notices WHERE id = ?");
                    $stmt->execute([$id]);
                    $notice = $stmt->fetch();
                    
                    if ($notice) {
                        $response['success'] = true;
                        $response['data'] = $notice;
                    } else {
                        $response['message'] = 'Notice not found';
                    }
                } catch(PDOException $e) {
                    $response['message'] = 'Database error: ' . $e->getMessage();
                }
            }
            break;
            
        case 'toggle_status':
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                try {
                    // Get current status
                    $stmt = $db->prepare("SELECT status FROM notices WHERE id = ?");
                    $stmt->execute([$id]);
                    $notice = $stmt->fetch();
                    
                    if ($notice) {
                        $new_status = ($notice['status'] === 'active') ? 'inactive' : 'active';
                        $stmt = $db->prepare("UPDATE notices SET status = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$new_status, $id]);
                        
                        $response['success'] = true;
                        $response['message'] = 'Status updated successfully';
                        $response['new_status'] = $new_status;
                    } else {
                        $response['message'] = 'Notice not found';
                    }
                } catch(PDOException $e) {
                    $response['message'] = 'Database error: ' . $e->getMessage();
                }
            }
            break;
    }
}

echo json_encode($response);
?>
