<?php
// Assuming $is_admin is a boolean variable indicating whether the user is an admin or not
$route = $_GET['route'] ?? 'dashboard';
$is_admin = false;
if ($is_admin) {
    switch ($route) {
        case "dashboard":
            require 'admin/view/dashboard/dashboard.php';
            break;
            // ORDER MANAGEMENT
        case "customer-order":
            require 'admin/view/order-management/customer-order.php';
            break;
        case "process-order":
            require 'admin/view/order-management/process-order.php';
            break;
        case "canceled-order":
            require 'admin/view/order-management/canceled-order.php';
            break;
            // MENU MANAGEMENT
        case "food-menu":
            require 'admin/view/menu-management/food-menu.php';
            break;
        case "category-management":
            require 'admin/view/menu-management/category.php';
            break;
            // CUSTOMER MANAGEMENT        
        case "customer-detail":
            require 'admin/view/customer-management/customer-detail.php';
            break;
        case "customer-feedback":
            require 'admin/view/customer-management/customer-feedback.php';
            break;
            // USER MANAGEMENT
        case "manage-clerk":
            require 'admin/view/customer-management/manage-clerk.php';
            break;
        default:
            require 'admin/view/dashboard/dashboard.php';
    }
} else {
    switch ($route) {
        case "privacy-policy":
            require 'user/view/privacy-policy/privacy_policy.php';
            break;
        case "eskina-order":
            require 'user/view/eskina-order/food_menu.php';
            break;
        default:
            require 'user/view/dashboard/dashboard.php';
    }
}
