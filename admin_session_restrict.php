<?php 
session_start();
if (!isset($_SESSION['user_role'])){
    header("Location: login.php");
    die();
}
?>