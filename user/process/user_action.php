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
        }else{
            $response = array(
                'success' => false,
                'message' => 'No Items Found'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'getMenubyMenuID') {
    if (empty($_POST['menu_id'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to Retrieve Menu ID'
        );
    } else {
        if (getFoodMenubyMenuID($pdo)) {
            $data = getFoodMenubyMenuID($pdo);
            $response = array(
                'success' => true,
                'menubyID' => $data
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'No Item Found'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}