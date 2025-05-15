<?php
// edit_task.php - For users/admin to edit a task
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task || (!is_admin() && $task['user_id'] != $_SESSION['user_id'])) {
    echo "Unauthorized or Task not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $update = $pdo->prepare("UPDATE tasks SET description = ? WHERE id = ?");
    $update->execute([$description, $id]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Task</h2>
        <input name="description" value="<?= htmlspecialchars($task['description']) ?>" required class="w-full mb-4 px-4 py-2 border rounded">
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update Task</button>
    </form>
</body>
</html>
