<?php
// Authentication helper functions

function requireAuth() {
    session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getAdminName() {
    return $_SESSION['admin_name'] ?? 'Admin User';
}

function getAdminEmail() {
    return $_SESSION['admin_email'] ?? '';
}
?>
