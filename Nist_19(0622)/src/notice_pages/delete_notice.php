<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include '/includes/db.php';

$noticeId = $_GET['id'];
$conn->query("DELETE FROM notices WHERE id = $noticeId");

header("Location: notice.php");
exit();