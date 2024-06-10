<?php
require_once '../../config.php';
require_once 'function.php';

if (!empty($_POST['action']) && $_POST['action'] == 'getMenu') {
}

if (!empty($_POST['action']) && $_POST['action'] == 'getMenubyID') {
    if (empty($_POST['category_id'])) {
        if (getFoodMenubyID($pdo)) {
            $data = getFoodMenubyID($pdo);
            $response = array(
                'success' => true,
                'menuList' => $data
            );
        }
    } else {
        if (getFoodMenubyID($pdo)) {
            $data = getFoodMenubyID($pdo);
            $response = array(
                'success' => true,
                'menuList' => $data
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
