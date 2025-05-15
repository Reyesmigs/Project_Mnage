<?php
require 'config.php'; // this already contains session_start()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];

        // ✅ Insert login log
        $logStmt = $pdo->prepare("INSERT INTO login_logs (user_id, username, ip_address) VALUES (?, ?, ?)");
        $logStmt->execute([
            $user['id'],
            $user['username'],
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login to Task Manager</h2>
        <input name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input name="password" type="password" placeholder="Password" required class="w-full px-4 py-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Login</button>
        <?php if (!empty($error)) echo "<p class='text-red-600 mt-4 text-center'>$error</p>"; ?>
        <p class="text-sm text-center mt-4">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Register here</a></p>
    </form>
</body>

</html>
