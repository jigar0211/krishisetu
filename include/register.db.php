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

    // Handle file upload directly without validation
    if (isset($_FILES['profile_picture'])) {
        $target_dir = "../uploads/profiles/";
        $file_name = uniqid() . '-' . basename($_FILES["profile_picture"]["name"]);  
        $profile_picture = $target_dir . $file_name;

        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profile_picture); // Upload the file directly
    } else {
        // Set a default image if no file was uploaded
        $file_name = 'default-profile.png'; // Ensure this file exists in your uploads folder
    }

    // Check if email already exists
    $conditions = [['where' => ['email' => $email], 'groupCondition' => 'AND']];
    $get_user = $db->get('authentication', '*', $conditions);
    if (!empty($get_user)) {
        echo json_encode(['status' => 'error', 'message' => 'Email already used!', 'title' => 'Error', 'icon' => 'error']);
        die;
    }

    // Check if contact number already exists
    $conditions = [['where' => ['contact_number' => $contact_number], 'groupCondition' => 'AND']];
    $get_user = $db->get('authentication', '*', $conditions);
    if (!empty($get_user)) {
        echo json_encode(['status' => 'error', 'message' => 'Contact number already used!', 'title' => 'Error', 'icon' => 'error']);
        die;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare data for insertion
    $values = [
        'auth_id' => uniqid(),
        'name' => $name,
        'email' => $email,
        'contact_number' => $contact_number,
        'password' => $hashed_password,
        'role' => "2", // Hardcoded role value
        'profession' => $profession,
        'location' => $location,
        'language' => $language,
        'profile_picture' => $file_name, // File name or default image
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Insert data into the `authentication` table
    $insert_id = $db->Insert('authentication', $values);

    if ($insert_id) {
        $_SESSION['krishisetu']['user_id'] = $values['auth_id']; // Save auth_id as user_id
        $_SESSION['krishisetu']['name'] = $name;
        $_SESSION['krishisetu']['email'] = $email;
        $_SESSION['krishisetu']['password'] = $password;

        // Success message
        echo json_encode(['status' => 'ok', 'message' => 'User registered successfully!', 'title' => 'Success', 'icon' => 'success', 'redirect_link' => 'dashboard.php']);
    } else {
        // Failure message, ensuring response for failed insertion
        echo json_encode(['status' => 'error', 'message' => 'Data insertion failed! Possible issue with database operation.', 'title' => 'Error', 'icon' => 'error', 'redirect_link' => 'dashboard.php']);
    }
}
