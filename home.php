<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="home-style.css">
</head>
<body>

<div class="home-box">
    <h1>Welcome!</h1>

    <p class="user-text">
        You are logged in as <strong><?= $_SESSION['user_name'] ?></strong>
    </p>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>