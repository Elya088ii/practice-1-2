<?php
// Общее меню навигации между сервисами
function renderMenu(): void
{
    echo "<nav style='text-align:center; margin-bottom:20px;'>";
    echo "<a href='index.php'>Главная</a> | ";
    echo "<a href='drawer.php'>Drawer (SVG)</a> | ";
    echo "<a href='sort.php'>Сортировка массива</a> | ";
    echo "<a href='server.php'>Информация о сервере</a>";
    echo "</nav>\n";
}