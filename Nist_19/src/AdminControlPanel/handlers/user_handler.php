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
        case 'check_username':
            $username = trim($_POST['username'] ?? '');
            $exclude_id = intval($_POST['exclude_id'] ?? 0);
            
            if (!empty($username)) {
                try {
                    if ($exclude_id > 0) {
                        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
                        $stmt->execute([$username, $exclude_id]);
                    } else {
                        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
                        $stmt->execute([$username]);
                    }
                    
                    $existing_user = $stmt->fetch();
                    
                    if ($existing_user) {
                        $response['message'] = 'Username already exists';
                    } else {
                        $response['success'] = true;
                        $response['message'] = 'Username available';
                    }
                } catch(PDOException $e) {
                    $response['message'] = 'Database error: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Username is required';
            }
            break;
            
        case 'get':
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                try {
                    $stmt = $db->prepare("SELECT id, username, role FROM users WHERE id = ?");
                    $stmt->execute([$id]);
                    $user = $stmt->fetch();
                    
                    if ($user) {
                        $response['success'] = true;
                        $response['data'] = $user;
                    } else {
                        $response['message'] = 'User not found';
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
