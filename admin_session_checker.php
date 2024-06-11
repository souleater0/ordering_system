<?php 
session_start();
// // Function to handle redirection with a single exit point
// function redirect($url) {
//     header("Location: $url");
//     exit;
// }
// // Check if the user is logged in
// if (isset($_SESSION['user_role'])) {
//     // Check the user's role
//     if (isset($_SESSION['user_role'])) {
//         switch ($_SESSION['user_role']) {
//             case 1:
//                 // Admin route
//                 redirect('index.php?route=dashboard');
//                 break;
//             case 2:
//                 // Cashier route
//                 redirect('index.php?route=customer-order');
//                 break;
//             default:
//                 // Role not recognized, log out and redirect to login
//                 echo 'Role not recognized. Logging out.';
//                 session_destroy();
//                 redirect('login.php');
//         }
//     } else {
//         // User role not set, redirect to login
//         echo 'User role not set. Redirecting to login.';
//         redirect('login.php');
//     }
// } else {
//     // Not logged in, redirect to login
//     // redirect('login.php');
//     // exit;
// }
function redirect($url) {
    header("Location: $url");
    exit;
}
if (isset($_SESSION['user_role'])){
        switch ($_SESSION['user_role']) {
            case 1:
                // Admin route
                redirect('index.php?route=dashboard');
                break;
            case 2:
                // Cashier route
                redirect('index.php?route=customer-order');
                break;
            default:
                // Role not recognized, log out and redirect to login
                echo 'Role not recognized. Logging out.';
                session_destroy();
                redirect('login.php');
        }
        
}
?>