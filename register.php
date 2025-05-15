<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'] ?? 'user';

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$username, $password, $role]);
        header("Location: login.php");
    } catch (PDOException $e) {
        $error = "Username already exists.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Create Account</h2>
        <input name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-green-500">
        <input name="password" type="password" placeholder="Password" required class="w-full px-4 py-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-green-500">
        <select name="role" class="w-full px-4 py-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Register</button>
        <?php if (!empty($error)) echo "<p class='text-red-600 mt-4 text-center'>$error</p>"; ?>
        <p class="text-sm text-center mt-4">Already registered? <a href="login.php" class="text-green-600 hover:underline">Login</a></p>
    </form>
</body>

</html>