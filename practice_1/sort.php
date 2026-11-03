<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/menu.php';
require_once __DIR__ . '/sort_lib.php';

$body = renderMenu();

$input = $_GET['arr'] ?? null;   // строка "5,3,8,1"
$algo  = $_GET['algo'] ?? 'quick';

if ($input === null) {
    $body .= "<p>Передайте массив в параметре arr (числа через запятую) и алгоритм в algo.</p>";
    $body .= "<p>Доступные алгоритмы: insertion, selection, quick, merge, shell.</p>";
    $body .= "<p>Пример: sort.php?arr=5,3,8,1,9&algo=quick</p>";
} else {
    // Устойчивость: разбираем строку, отбрасываем нечисловые элементы
    $parts = explode(',', $input);
    $numbers = [];
    $invalid = [];
    foreach ($parts as $p) {
        $p = trim($p);
        if ($p === '') continue;
        if (is_numeric($p)) $numbers[] = (float)$p;
        else $invalid[] = $p;
    }

    if (!empty($invalid)) {
        $body .= "<p style='color:red;'>Пропущены некорректные значения: "
               . e(implode(', ', $invalid)) . "</p>";
    }

    if (count($numbers) === 0) {
        $body .= "<p style='color:red;'>Ошибка: не передано ни одного числа.</p>";
    } else {
        $result = applySort($algo, $numbers);
        if ($result === null) {
            $body .= "<p style='color:red;'>Ошибка: неизвестный алгоритм '"
                   . e($algo) . "'.</p>";
        } else {
            $body .= "<p>Исходный массив: <b>" . e(implode(', ', $numbers)) . "</b></p>";
            $body .= "<p>Алгоритм: <b>" . e($algo) . "</b></p>";
            $body .= "<p>Отсортированный массив: <b>" . e(implode(', ', $result)) . "</b></p>";
        }
    }
}

renderPage('Сортировка массива', $body);