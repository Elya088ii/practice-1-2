<?php
require_once __DIR__ . '/session_handler.php';

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['theme'] = $_POST['theme'] ?? 'light';
    $_SESSION['language'] = $_POST['language'] ?? 'ru';
    // Дублируем в cookie на 30 дней
    setcookie('theme', $_SESSION['theme'], time() + 86400*30, '/');
    setcookie('language', $_SESSION['language'], time() + 86400*30, '/');
    header('Location: profile.php');
    exit;
}

// Читаем текущие настройки (приоритет: сессия -> cookie -> дефолт)
$theme = $_SESSION['theme'] ?? $_COOKIE['theme'] ?? 'light';
$language = $_SESSION['language'] ?? $_COOKIE['language'] ?? 'ru';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($language) ?>">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: <?= $theme === 'dark' ? '#222' : ($theme === 'colorblind' ? '#f0f0f0' : '#fff') ?>;
            color: <?= $theme === 'dark' ? '#eee' : '#000' ?>;
        }
        nav a { margin: 0 10px; color: <?= $theme === 'dark' ? '#8ab4f8' : 'blue' ?>; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Главная</a>
        <a href="/delivery.html">Доставка</a>
        <a href="/contacts.html">Контакты</a>
        <a href="/profile.php">Профиль</a>
        <a href="/upload.php">Загрузить PDF</a>
        <a href="/files.php">Мои PDF</a>
    </nav>
    <h1>Настройки профиля</h1>
    <form method="post">
        <label>Тема:
            <select name="theme">
                <option value="light" <?= $theme === 'light' ? 'selected' : '' ?>>Светлая</option>
                <option value="dark" <?= $theme === 'dark' ? 'selected' : '' ?>>Тёмная</option>
                <option value="colorblind" <?= $theme === 'colorblind' ? 'selected' : '' ?>>Для цветовой слепоты</option>
            </select>
        </label>
        <br><br>
        <label>Язык:
            <select name="language">
                <option value="ru" <?= $language === 'ru' ? 'selected' : '' ?>>Русский</option>
                <option value="en" <?= $language === 'en' ? 'selected' : '' ?>>English</option>
            </select>
        </label>
        <br><br>
        <button type="submit">Сохранить</button>
    </form>
    <p>Текущая тема: <?= htmlspecialchars($theme) ?>, язык: <?= htmlspecialchars($language) ?></p>
</body>
</html>