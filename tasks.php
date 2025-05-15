<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

$is_admin = is_admin();
if ($is_admin) {
    $stmt = $pdo->query("SELECT tasks.*, users.username FROM tasks JOIN users ON tasks.user_id = users.id ORDER BY created_at DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['user_id']]);
}
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Task List</h1>
            <a href="index.php" class="text-sm text-blue-600 hover:underline">← Back to Dashboard</a>
        </div>

        <!-- Task Form -->
        <form action="add_task.php" method="POST" class="flex flex-col sm:flex-row gap-4 mb-6">
            <input 
                name="description" 
                placeholder="Enter a new task..." 
                required 
                class="flex-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <?php if ($is_admin): ?>
                <select name="user_id" required class="px-4 py-2 border rounded w-full sm:w-auto">
                    <?php
                    $users = $pdo->query("SELECT id, username FROM users")->fetchAll();
                    foreach ($users as $user):
                    ?>
                        <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Add Task
            </button>
        </form>

        <!-- Task List -->
        <ul class="space-y-4">
            <?php foreach ($tasks as $task): ?>
                <li class="bg-gray-50 p-4 rounded-lg shadow flex justify-between items-start">
                    <div>
                        <p class="text-gray-800 font-medium"><?= htmlspecialchars($task['description']) ?></p>
                        <?php if ($is_admin): ?>
                            <p class="text-sm text-gray-500 mt-1">Assigned to: <?= htmlspecialchars($task['username']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="edit_task.php?id=<?= $task['id'] ?>" class="text-sm text-blue-600 hover:underline">Edit</a>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="text-sm text-red-600 hover:underline">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (empty($tasks)): ?>
            <p class="text-center text-gray-500 mt-6">No tasks found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
