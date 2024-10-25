<?php

include_once './include/connection.php';
include_once './include/auth.php';

if (count($_REQUEST) > 0 && $_REQUEST['file']) {
    $file = $_REQUEST['file'];
    if (is_file(SYSPATH . "/include/" . $file . '.php')) {
        include SYSPATH . "/include/" . $file . ".php";
    } else {
        echo json_encode(array("status" => "Error", "message" => "Not Valid File.", "class" => "danger"));
    }
} else {
    echo json_encode(array("status" => "Error", "message" => "File param is missing.", "class" => "danger"));
}
?>