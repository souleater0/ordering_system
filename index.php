<?php
$is_admin = false;
if ($is_admin) {
    // include("admin/index.php");
    header('Location: admin/index.php?route=dashboard');
    exit;
} else {
    // include("user/index.php");
    header('Location: user/index.php?route=home');
    exit;
}
