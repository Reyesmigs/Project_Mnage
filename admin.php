<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();
if (!is_admin()) die("Access denied.");

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Admin Panel - Manage Users</h1>

        <table class="w-full text-left border border-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 border-b">Username</th>
                    <th class="p-3 border-b">Role</th>
                    <th class="p-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="p-3 border-b"><?= htmlspecialchars($u['username']) ?></td>
                        <td class="p-3 border-b"><?= $u['role'] ?></td>
                        <td class="p-3 border-b">
                            <?php if ($u['role'] !== 'admin'): ?>
                                <a href="delete_user.php?id=<?= $u['id'] ?>" class="text-red-600 hover:underline">Delete</a>
                            <?php else: ?>
                                <span class="text-gray-500">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="index.php" class="inline-block mt-6 text-blue-600 hover:underline">← Back to Dashboard</a>
    </div>
</body>

</html>