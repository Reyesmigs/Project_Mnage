<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_if_not_logged_in() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>
