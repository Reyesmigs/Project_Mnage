<?php
// edit_project.php - Admin editing a project
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

if (!is_admin()) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    echo "Project not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $progress = $_POST['progress'];
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    $update = $pdo->prepare("UPDATE projects SET name = ?, progress = ?, status = ?, due_date = ? WHERE id = ?");
    $update->execute([$name, $progress, $status, $due_date, $id]);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Project</h2>
        <input name="name" value="<?= htmlspecialchars($project['name']) ?>" required class="w-full mb-4 px-4 py-2 border rounded">
        <input name="progress" type="number" min="0" max="100" value="<?= $project['progress'] ?>" required class="w-full mb-4 px-4 py-2 border rounded">
        <input name="status" value="<?= htmlspecialchars($project['status']) ?>" required class="w-full mb-4 px-4 py-2 border rounded">
        <input name="due_date" type="date" value="<?= $project['due_date'] ?>" required class="w-full mb-4 px-4 py-2 border rounded">
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update Project</button>
    </form>
</body>
</html>
