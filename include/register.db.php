<?php
include_once './connection.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "register_user") {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $password = $_POST['password'] ?? '';
    $profession = isset($_POST['profession']) && is_array($_POST['profession']) ? implode(',', $_POST['profession']) : '';
    $language = $_POST['language'] ?? '';
    $location = $_POST['location'] ?? '';

    $profile_picture = '';
    $file_name = null;

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/profiles/";
        $file_name = uniqid() . '-' . basename($_FILES["profile_picture"]["name"]);
        $profile_picture = $target_dir . $file_name;

        if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profile_picture)) {
            $file_name = 'default-profile.png';
        }
    } else {
        $file_name = 'default-profile.png';
    }

    $conditions = [['where' => ['email' => $email], 'groupCondition' => 'AND']];
    $get_user = $db->get('authentication', '*', $conditions);
    if (!empty($get_user)) {
        echo json_encode(['status' => 'error', 'message' => 'Email already used!', 'title' => 'Error', 'icon' => 'error']);
        die;
    }

    $conditions = [['where' => ['contact_number' => $contact_number], 'groupCondition' => 'AND']];
    $get_user = $db->get('authentication', '*', $conditions);
    if (!empty($get_user)) {
        echo json_encode(['status' => 'error', 'message' => 'Contact number already used!', 'title' => 'Error', 'icon' => 'error']);
        die;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $values = [
        'auth_id' => uniqid(),
        'name' => $name,
        'email' => $email,
        'contact_number' => $contact_number,
        'password' => $hashed_password,
        'role' => "2",
        'profession' => $profession,
        'location' => $location,
        'language' => $language,
        'profile_picture' => $file_name,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $insert_id = $db->Insert('authentication', $values);

    if (empty($insert_id)) {
        $_SESSION['krishisetu']['user_id'] = $values['auth_id'];
        $_SESSION['krishisetu']['name'] = $name;
        $_SESSION['krishisetu']['email'] = $email;

        echo json_encode(['status' => 'ok', 'message' => 'User registered successfully!', 'title' =>'Success', 'page' => 'redirect', 'redirect_link' => 'dashboard.php']);
    } else {
        // Failure message
        echo json_encode(['status' => 'error', 'message' => 'Data insertion failed! Possible issue with database operation.', 'title' => 'Error', 'icon' => 'error']);
    }
}
