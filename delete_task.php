<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

$task_id = $_GET['id'];

if (is_admin()) {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$task_id]);
} else {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $_SESSION['user_id']]);
}

header("Location: index.php");
exit();
?>
