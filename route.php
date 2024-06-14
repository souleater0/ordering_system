<?php
// Assuming $is_admin is a boolean variable indicating whether the user is an admin or not
$route = $_GET['route'] ?? 'dashboard';
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 1) {
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
            case "manage-variation":
                require 'admin/view/menu-management/variation.php';
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
            case "user-management":
                require 'admin/view/user-management/users.php';
                break;
            default:
            require 'admin/view/dashboard/dashboard.php';
        }
    }
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 2) {
        switch ($route) {
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
                // USER MANAGEMENT
                case "user-management":
                    require 'admin/view/user-management/users.php';
                    break;
            default:
            require 'admin/view/no-access/404.php';
        }
    }
}else {
    switch ($route) {
        case "privacy-policy":
            require 'user/view/privacy-policy/privacy_policy.php';
            break;
        case "personal-form":
            require 'user/view/personal-form/personal_form.php';
            break;
        case "user-overview":
            require 'user/view/user-overview/user_overview.php';
            break;
        case "eskina-order":
            require 'user/view/eskina-order/eskina_order.php';
            break;
        default:
        require 'user/view/privacy-policy/privacy_policy.php';
    }
}
