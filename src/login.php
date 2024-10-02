<?php
session_start();
include_once 'config.php';

class Auth {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = 'SELECT * FROM users WHERE username = :username LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            return true;
        } else {
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $auth = new Auth($db);

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if ($auth->login($username, $password)) {
        header('Location: dashboard.php');
    } else {
        echo 'Login failed';
    }
}
?>

<!-- Simple HTML Form for Login -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <form action="login.php" method="POST" class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl mb-6 text-center">Login</h2>
        <input type="text" name="username" placeholder="Username" required class="border border-gray-300 p-2 mb-4 w-full rounded">
        <input type="password" name="password" placeholder="Password" required class="border border-gray-300 p-2 mb-4 w-full rounded">
        <button type="submit" class="bg-blue-500 text-white py-2 rounded w-full hover:bg-blue-600">Login</button>
    </form>
</body>
</html>
