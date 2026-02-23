<?php
session_start();
require __DIR__ . '/../config/Database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Пароли не совпадают!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Пользователь с таким email уже существует!";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
            $stmt->execute([$username, $email, $passwordHash]);

            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $username;

            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #e8f5e9, #f1f8f4); 
        }
        .card { 
            border-radius: 16px; 
        }
        .badge-custom { 
            background-color: #28a745; 
        }
        .btn-success { 
            background-color: #28a745; 
            border: none; 
        }
        .btn-success:hover { 
            background-color: #218838; 
        }
        .btn-outline-secondary { 
            border-color: #28a745; 
            color: #28a745; 
        }
        .btn-outline-secondary:hover { 
            background-color: #28a745; 
            color: #fff; 
        }
        .form-control:focus { 
            border-color: #28a745; 
            box-shadow: 0 0 0 0.15rem rgba(40,167,69,0.25); 
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <span class="badge badge-custom rounded-circle p-3" style="font-size:2rem">👤</span>
                        <h3 class="mt-3">Создайте аккаунт</h3>
                        <p class="text-muted">Заполните форму для регистрации</p>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Имя" required>
                            <label for="username">👤 Имя пользователя</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            <label for="email">📧 Email адрес</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" required minlength="6">
                            <label for="password">🔒 Пароль</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Повтор" required>
                            <label for="confirm">🔒 Повторите пароль</label>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">Зарегистрироваться</button>
                    </form>

                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-muted">или</span>
                        <hr class="flex-grow-1">
                    </div>

                    <a href="login.php" class="btn btn-outline-secondary w-100">Войти в существующий аккаунт</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>