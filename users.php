<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();

if (!is_admin()) {
    echo "Access denied.";
    exit();
}

$users = $pdo->query("SELECT id, username, role FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Users</h2>
        <ul class="divide-y">
            <?php foreach ($users as $user): ?>
                <li class="py-2 text-sm text-gray-700">
                    <?= htmlspecialchars($user['username']) ?> (<?= $user['role'] ?>)
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php" class="mt-6 inline-block text-blue-600 hover:underline">Back to Dashboard</a>
    </div>
</body>
</html>
