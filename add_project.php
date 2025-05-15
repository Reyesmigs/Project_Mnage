<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $progress = $_POST['progress'];
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    $stmt = $pdo->prepare("INSERT INTO projects (name, progress, status, due_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $progress, $status, $due_date]);

    header("Location: index.php");
    exit();
}
?>
