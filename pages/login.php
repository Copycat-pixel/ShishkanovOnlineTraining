<?php
session_start();
require __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: ../pages/index.php');
        exit;
    } else {
        $error = "Неверный email или пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f1f8f4, #e8f5e9); }
        .card { border-radius: 16px; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-success:hover { background-color: #218838; }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.15rem rgba(40,167,69,0.25); }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3>Вход в аккаунт</h3>
                        <p class="text-muted">Введите свои данные</p>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            <label for="email">📧 Email адрес</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" required>
                            <label for="password">🔒 Пароль</label>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">Войти</button>
                    </form>

                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-muted">или</span>
                        <hr class="flex-grow-1">
                    </div>

                    <a href="register.php" class="btn btn-outline-secondary w-100">Создать аккаунт</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>