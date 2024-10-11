<?php
session_start();

// Redirect users based on their login status or roles
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'employer') {
        header('Location: employer_dashboard.php');
        exit();
    } elseif ($_SESSION['role'] === 'job_seeker') {
        header('Location: job_seeker_dashboard.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Job Portal</h1>
        <a href="login.php" class="text-blue-500 hover:underline">Login</a>
        <span class="mx-2">|</span>
        <a href="create_user.php" class="text-blue-500 hover:underline">Register</a>
    </div>
</body>
</html>
