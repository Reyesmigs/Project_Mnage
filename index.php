<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

$is_admin = is_admin();

// Fetch project data
$projects = $pdo->query("SELECT * FROM projects ORDER BY due_date DESC")->fetchAll();

// Fetch task count
$taskCount = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();

// Fetch login logs (recent 10 entries)
$logs = [];
if ($is_admin) {
    $logs = $pdo->query("SELECT * FROM login_logs ORDER BY login_time DESC LIMIT 10")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen">
            <div class="p-4 text-center font-bold text-xl border-b border-gray-700">
                <?= $is_admin ? 'ADMIN' : 'USER' ?>
            </div>
            <nav class="mt-6">
                <a href="index.php" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="project.php" class="block px-4 py-2 hover:bg-gray-700">Projects</a>
                <a href="tasks.php" class="block px-4 py-2 hover:bg-gray-700">Tasks</a>
                <?php if ($is_admin): ?>
                    <a href="users.php" class="block px-4 py-2 hover:bg-gray-700">Users</a>
                    <a href="login_logs.php" class="block px-4 py-2 hover:bg-gray-700">Login Logs</a>
                <?php endif; ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Home</h1>
                <div class="text-gray-600">
                    Welcome <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?>!
                </div>
            </div>

            <!-- Project Progress Section -->
            <div id="project-section" class="bg-white rounded shadow p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-lg">Project Progress</h2>
                    <?php if ($is_admin): ?>
                        <a href="add_project.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Project</a>
                    <?php endif; ?>
                </div>
                <div class="space-y-4">
                    <?php foreach ($projects as $project):
                        $progress = (int) $project['progress'];
                        $status = htmlspecialchars($project['status']);
                        $due = htmlspecialchars($project['due_date']);
                    ?>
                    <div class="border p-4 rounded">
                        <div class="flex justify-between items-center mb-2">
                            <div class="font-medium text-gray-800"> <?= htmlspecialchars($project['name']) ?> </div>
                            <div class="flex gap-2">
                                <span class="text-sm px-2 py-1 rounded bg-blue-100 text-blue-700"> <?= $status ?> </span>
                                <a href="view_project.php?id=<?= $project['id'] ?>" class="text-blue-600 hover:underline text-sm">View</a>
                                <?php if ($is_admin): ?>
                                    <a href="edit_project.php?id=<?= $project['id'] ?>" class="text-yellow-600 hover:underline text-sm">Edit</a>
                                    <a href="delete_project.php?id=<?= $project['id'] ?>" class="text-red-600 hover:underline text-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 h-3 rounded">
                            <div class="bg-green-500 h-3 rounded" style="width: <?= $progress ?>%;"></div>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">Due: <?= $due ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="text-3xl font-bold"><?= count($projects) ?></div>
                    <div class="text-gray-500">Total Projects</div>
                </div>
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="text-3xl font-bold"><?= $taskCount ?></div>
                    <div class="text-gray-500">Total Tasks</div>
                </div>
            </div>

            <!-- Login Logs Section -->
            <?php if ($is_admin): ?>
            <div id="login-logs" class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">Recent Login Logs</h2>
                <ul class="divide-y">
                    <?php foreach ($logs as $log): ?>
                    <li class="py-2 text-sm text-gray-700">
                        <?= htmlspecialchars($log['username']) ?> logged in at <?= $log['login_time'] ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
