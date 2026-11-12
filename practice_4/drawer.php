<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/menu.php';
require_once __DIR__ . '/drawer_lib.php';

$num = $_GET['num'] ?? null;

$body = renderMenu();

if ($num === null || !is_numeric($num)) {
    // Устойчивость к ошибке: параметр не передан или не является числом
    $body .= "<p style='color:red;'>Ошибка: передайте целое число в параметре num. Пример: drawer.php?num=2</p>";
} else {
    $n = (int)$num;
    if ($n < 0) {
        $body .= "<p style='color:red;'>Ошибка: число должно быть неотрицательным.</p>";
    } else {
        $params = decodeShape($n);
        $body .= "<p>Число: <b>" . e($n) . "</b>; форма: <b>" . e($params['shape'])
               . "</b>; цвет: <b>" . e($params['color'])
               . "</b>; размер: <b>" . e($params['size']) . " px</b></p>";
        $body .= "<div style='text-align:center;'>" . renderSvg($params) . "</div>";
    }
}

renderPage('Drawer — рисование SVG', $body);