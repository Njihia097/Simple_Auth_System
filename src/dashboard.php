<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

echo 'Welcome, ' . $_SESSION['username'];
?>

<!-- HTML for Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen flex-col">
    <h1 class="text-3xl mb-4">Welcome to your Dashboard</h1>
    <p class="mb-6">This page is accessible only to logged-in users.</p>
    <a href="logout.php" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Logout</a>
</body>
</html>

