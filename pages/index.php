<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Главная</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">
    <h1>Привет, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
    <p>Вы вошли в систему.</p>

    <a href="logout.php" class="btn btn-danger mt-3">Выйти</a>
</div>
</body>
</html>