<?php
// project.php - Project creation for users (and admins)
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Create Project</h2>
        <input name="name" placeholder="Project Name" required class="w-full mb-4 px-4 py-2 border rounded">
        <input name="progress" type="number" min="0" max="100" value="0" required class="w-full mb-4 px-4 py-2 border rounded">
        <input name="status" placeholder="Status" required class="w-full mb-4 px-4 py-2 border rounded">
        <input name="due_date" type="date" required class="w-full mb-4 px-4 py-2 border rounded">
        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Create Project</button>
    </form>
</body>
</html>
