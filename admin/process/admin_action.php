<?php
session_start();
require_once '../../config.php';
require_once 'function.php';
if(!empty($_POST['action']) && $_POST['action'] == 'loginProcess') {
    if(loginProcess($pdo)){
        $response = array(
            'success' => true,
            'message' => 'Login successful.',
            'redirectUrl' => '../index.php?route=dashboard'
        );
    }else{
        $response = array(
            'success' => false,
            'message' => 'Invalid Credentials!'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addUser') {
    if(empty($_POST['user_display'])){
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    }
    else if(empty($_POST['username'])){
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    }
    else{
        if(addUser($pdo)){
            $response = array(
                'success' => true,
                'message' => 'User has been created.'
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Failed to create new user!'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateUser') {
    if(empty($_POST['user_display'])){
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    }
    else if(empty($_POST['username'])){
        $response = array(
            'success' => false,
            'message' => 'Please enter a display name!'
        );
    }
    else{
        if(updateUser($pdo)){
            $response = array(
                'success' => true,
                'message' => 'User has been updated.'
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Failed to update user!'
            );
        }
    }
    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateUserPassword') {
    if(empty($_POST['password'])){
        $response = array(
            'success' => false,
            'message' => 'Please enter a password!'
        );
    }else if (empty($_POST['c_password'])){
        $response = array(
            'success' => false,
            'message' => 'Please enter a confirm password!'
        );
    }else{
        if(updateUserPassword($pdo)){
            $response = array(
                'success' => true,
                'message' => 'User password has been updated.'
            );
        }else{
            $response = array(
                'success' => false,
                'message' => 'Failed to update password!'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>