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
                    $stmt = $db->prepare("SELECT * FROM activities WHERE id = ?");
                    $stmt->execute([$id]);
                    $activity = $stmt->fetch();
                    
                    if ($activity) {
                        $response['success'] = true;
                        $response['data'] = $activity;
                    } else {
                        $response['message'] = 'Activity not found';
                    }
                } catch(PDOException $e) {
                    $response['message'] = 'Database error: ' . $e->getMessage();
                }
            }
            break;
            
        case 'upload_image':
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = '../uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($file_extension, $allowed_extensions)) {
                    $filename = uniqid() . '.' . $file_extension;
                    $upload_path = $upload_dir . $filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $response['success'] = true;
                        $response['message'] = 'Image uploaded successfully';
                        $response['file_path'] = str_replace('../', '', $upload_path);
                    } else {
                        $response['message'] = 'Failed to upload image';
                    }
                } else {
                    $response['message'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
                }
            } else {
                $response['message'] = 'No image file provided';
            }
            break;
    }
}

echo json_encode($response);
?>
