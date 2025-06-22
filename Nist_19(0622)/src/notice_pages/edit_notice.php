<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include '/includes/db.php';

$noticeId = $_GET['id'];
$notice = $conn->query("SELECT * FROM notices WHERE id = $noticeId")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE notices SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $noticeId);
    $stmt->execute();
    $stmt->close();

    header("Location: notice.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notice</title>
    <link href="../output.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-4">Edit Notice</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" value="<?php echo $notice['title']; ?>" required class="w-full border border-gray-300 rounded py-2 px-3">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-medium mb-2">Content</label>
                <textarea id="content" name="content" required class="w-full border border-gray-300 rounded py-2 px-3"><?php echo $notice['content']; ?></textarea>
            </div>
            <button type="submit" class="bg-primary text-white py-2 px-4 rounded hover:bg-secondary">Update Notice</button>
        </form>
    </div>
</body>
</html>