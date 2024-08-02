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
        if ($orderNo = orderNow($pdo)) {
            $response = array(
                'success' => true,
                'message' => 'Order Successful.',
                'order_no' => $orderNo
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to Order!'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if (!empty($_POST['action']) && $_POST['action'] == 'recordCustomer') {
    if (empty($_POST['fullname'])) {
        $response = array(
            'success' => false,
            'message' => 'Please Enter you Fullname.'
        );
    }else{
        if(saveCustomerDetails($pdo)){
            $response = array(
                'success' => true,
                'message' => 'Customer has been recorded.'
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Failed to record Customer!.'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if (!empty($_POST['action']) && $_POST['action'] == 'submitFeedback') {
    if (empty($_POST['fullname'])) {
        $response = array(
            'success' => false,
            'message' => 'Failed to retrieve Name'
        );
    }else if (empty($_POST['rating'])) {
        $response = array(
            'success' => false,
            'message' => 'Please select a rate.'
        );
    }else if (empty($_POST['remarks'])) {
        $response = array(
            'success' => false,
            'message' => 'Please enter your feedback.'
        );
    }else{
        if(saveCustomerFeedback($pdo)){
            $response = array(
                'success' => true,
                'message' => 'Thank you for your feedback.'
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Failed to record Customer Feedback!.'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}