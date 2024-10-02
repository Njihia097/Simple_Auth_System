<?php
session_start();
include_once 'config.php';

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO users (username, password) VALUES (:username, :password)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password_hash);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $user = new User($db);

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if ($user->register($username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
    } else {
        echo 'Registration failed';
    }
}
?>

<!-- Simple HTML Form for Signup -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <form action="signup.php" method="POST" class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl mb-6 text-center">Create an Account</h2>
        <input type="text" name="username" placeholder="Username" required class="border border-gray-300 p-2 mb-4 w-full rounded">
        <input type="password" name="password" placeholder="Password" required class="border border-gray-300 p-2 mb-4 w-full rounded">
        <button type="submit" class="bg-blue-500 text-white py-2 rounded w-full hover:bg-blue-600">Sign Up</button>
    </form>
</body>
</html>
