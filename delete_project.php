<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

if (!is_admin()) exit('Access denied');

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: index.php");
exit();
?>
