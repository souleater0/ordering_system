<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // include("admin/index.php");
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 1) {
        //admin route
        header('Location: admin/index.php?route=dashboard');
        exit;
    }
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 2) {
        //cashier route
        header('Location: admin/index.php?route=dashboard');
        exit;
    }

} else {
    // include("user/index.php");
    header('Location: user/index.php?route=privacy-policy');
    exit;
}
