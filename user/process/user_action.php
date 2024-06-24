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

if (!empty($_POST['action']) && $_POST['action'] == 'getFoodDetailsbyID') {
    if (empty($_POST['menu_id'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to Retrieve Menu ID'
        );
    } 
    else {
        if (getFoodDetailsbyID($pdo)) {
            $data = getFoodDetailsbyID($pdo);
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
if (!empty($_POST['action']) && $_POST['action'] == 'getMenubyMenuID') {
    if (empty($_POST['menu_id'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to Retrieve Menu ID'
        );
    } 
    else if (empty($_POST['variation_id'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to Retrieve Variation ID'
        );
    }
    else {
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
if (!empty($_POST['action']) && $_POST['action'] == 'orderNow') {
    if (empty($_POST['tableNo'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to Retrieve Table No.'
        );
    }
    else if (empty($_POST['fullname'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to Retrieve Customer Name'
        );
    }
    else {
        if (orderNow($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Order Successful.'
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Failed to Order!.'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

