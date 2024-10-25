<?php
// Check if user is already logged in
if (!isset($_SESSION['krishisetu']['user_id'])) {
    header('Location: login.php');
    exit;
}

$currentTab = basename($_SERVER['PHP_SELF']);
$login_user_role_id = GetLoginUserRole();
$login_user_id = GetLoginUserId();

// Fetch the logged-in user's data
$logged_user = $db->fetch('users', $login_user_id);
$language = $logged_user->lang;

// Include the appropriate language file
include_once SYSPATH . "lang/{$language}.php";