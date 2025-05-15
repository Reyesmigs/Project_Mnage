<?php
require 'config.php';
require 'functions.php';
redirect_if_not_logged_in();
if (!is_admin()) die("Access denied.");

$logs = $pdo->query("SELECT l.*, u.username as actor, tu.username as target_user 
                     FROM audit_logs l
                     LEFT JOIN users u ON l.user_id = u.id
                     LEFT JOIN users tu ON l.target_user_id = tu.id
                     ORDER BY l.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Audit Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Audit Logs</h1>
        <table class="w-full border text-left">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 border-b">Actor</th>
                    <th class="p-3 border-b">Action</th>
                    <th class="p-3 border-b">Target</th>
                    <th class="p-3 border-b">Details</th>
                    <th class="p-3 border-b">Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr class="border-t hover:bg-gray-100">
                        <td class="p-3"><?= htmlspecialchars($log['actor']) ?></td>
                        <td class="p-3"><?= $log['action'] ?></td>
                        <td class="p-3"><?= htmlspecialchars($log['target_user']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($log['details']) ?></td>
                        <td class="p-3"><?= $log['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="mt-6 inline-block text-blue-600 hover:underline">← Back to Dashboard</a>
    </div>
</body>

</html>