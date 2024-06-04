<?php
$is_admin = true;
if ($is_admin) {
    include("admin/index.php");
} else {
    include("index.php");
}
