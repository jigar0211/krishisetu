<?php
include_once './connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'login_user') {
    $emailUsername = $_POST['emailusername'];
    $password = $_POST['password'];

    if (empty($emailUsername) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in both fields.', 'title' => 'Error', 'icon' => 'error']);
        exit();
    }

    $conditions = [
        [
            'where' => ['email' => $emailUsername, 'name' => $emailUsername],
            'groupCondition' => 'OR'
        ]
    ];

    $user = $db->get('authentication', '*', $conditions);
    // print_r($user); // Debugging output

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['krishisetu']['user_id'] = $user['auth_id']; // Corrected from $values
            $_SESSION['krishisetu']['name'] = $user['name'];
            $_SESSION['krishisetu']['email'] = $user['email'];
            // Remember me functionality
            if ($rememberMe) {
                $token = bin2hex(random_bytes(16)); // Generate a secure token
                $expiryTime = time() + (30 * 24 * 60 * 60); // 30 days from now
                setcookie('remember_me_token', $token, $expiryTime, "/");
            }
            echo json_encode(['status' => 'ok', 'message' => 'Login successful!', 'title' => 'Success', 'page' => 'redirect', 'redirect_link' => 'dashboard.php']);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Password mismatch!', 'title' => 'Error', 'icon' => 'error']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found!', 'title' => 'Error', 'icon' => 'error']);
        exit();
    }
}
