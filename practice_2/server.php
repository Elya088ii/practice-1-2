<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/menu.php';
require_once __DIR__ . '/server_lib.php';

$body = renderMenu();

$selected = $_GET['cmd'] ?? 'whoami';
$output = runSafeCommand($selected);

$body .= "<form method='get' style='text-align:center; margin-bottom:20px;'>";
$body .= "<label>Команда: <select name='cmd'>";
foreach (['whoami','id','pwd','uname','ls','ps'] as $c) {
    $sel = ($c === $selected) ? ' selected' : '';
    $body .= "<option value='" . e($c) . "'$sel>" . e($c) . "</option>";
}
$body .= "</select></label> ";
$body .= "<button type='submit'>Выполнить</button>";
$body .= "</form>";

if ($output === null) {
    $body .= "<p style='color:red;'>Ошибка: команда '"
           . e($selected) . "' не разрешена.</p>";
} else {
    $body .= "<h2>Результат выполнения <code>" . e($selected) . "</code>:</h2>";
    $body .= "<pre style='background:#f4f4f4; padding:10px; border:1px solid #ccc; "
           . "overflow:auto; text-align:left;'>" . e($output) . "</pre>";
}

renderPage('Информация о сервере', $body);