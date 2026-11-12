<?php
// Общие функции, используемые во всех трёх сервисах

/**
 * Безопасный вывод строки в HTML (защита от XSS).
 */
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Вывод стандартного HTML-каркаса страницы.
 * Принимает заголовок и HTML-содержимое тела.
 */
function renderPage(string $title, string $bodyHtml): void
{
    echo "<!DOCTYPE html>\n<html lang='ru'>\n<head>\n";
    echo "<meta charset='UTF-8'>\n";
    echo "<title>" . e($title) . "</title>\n";
    echo "<link rel='stylesheet' href='style.css' type='text/css'/>\n";
    echo "</head>\n<body>\n";
    echo "<h1>" . e($title) . "</h1>\n";
    echo $bodyHtml;
    echo "</body>\n</html>\n";
}