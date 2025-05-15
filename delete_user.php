<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();
if (!is_admin()) die("Access denied.");

$id = $_GET['id'];
$pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);

header("Location: admin.php");
exit();
