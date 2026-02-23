<?php
require 'config/Database.php';
require 'vendor/autoload.php';

use Faker\Factory;

$faker = Factory::create('ru_RU');

echo "Начинаем наполнение базы данных...\n";

echo "Создаем пользователей...\n";

$teacherIds = [];
$studentIds = [];

for ($i = 0; $i < 3; $i++) {
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (?, ?, ?, 'teacher')
    ");

    $stmt->execute([
        $faker->name,
        $faker->unique()->email,
        password_hash('123456', PASSWORD_DEFAULT)
    ]);

    $teacherIds[] = $pdo->lastInsertId();
}

for ($i = 0; $i < 10; $i++) {
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (?, ?, ?, 'student')
    ");

    $stmt->execute([
        $faker->name,
        $faker->unique()->email,
        password_hash('123456', PASSWORD_DEFAULT)
    ]);

    $studentIds[] = $pdo->lastInsertId();
}

echo "Пользователи осозданы\n";


echo "Создаем курсы...\n";

$courseIds = [];

for ($i = 0; $i < 5; $i++) {

    $stmt = $pdo->prepare("
        INSERT INTO courses (title, description, teacher_id)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $faker->sentence(3),
        $faker->realText(200),
        $teacherIds[array_rand($teacherIds)]
    ]);

    $courseIds[] = $pdo->lastInsertId();
}

echo "Курсы созданы\n";