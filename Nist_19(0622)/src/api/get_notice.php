<?php
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

try {
    // Use MySQLi connection from your database.php
    // Example: $conn = new mysqli($host, $user, $pass, $dbname);
    // Make sure $conn is available here

    // Get limit parameter (default 10)
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $limit = min($limit, 50); // Maximum 50 notices

    // Get status filter (default active only)
    $status = isset($_GET['status']) ? $_GET['status'] : 'active';

    if ($status === 'all') {
        $stmt = $conn->prepare("SELECT id, title, description, date, status, created_at FROM notices ORDER BY date DESC, created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
    } else {
        $stmt = $conn->prepare("SELECT id, title, description, date, status, created_at FROM notices WHERE status = ? ORDER BY date DESC, created_at DESC LIMIT ?");
        $stmt->bind_param("si", $status, $limit);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $notices = [];
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
    $stmt->close();

    $response = [
        'success' => true,
        'count' => count($notices),
        'data' => $notices
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
?>