<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

$description = $_POST['description'];
$user_id = is_admin() ? $_POST['user_id'] : $_SESSION['user_id'];

$stmt = $pdo->prepare("INSERT INTO tasks (description, user_id, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$description, $user_id]);

header("Location: index.php");
exit();
?>
