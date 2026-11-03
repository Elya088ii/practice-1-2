<?php
// Безопасное выполнение Unix-команд для вывода информации о сервере

/**
 * Выполняет разрешённую команду и возвращает её вывод.
 * Если команда не входит в белый список — возвращает null.
 */
function runSafeCommand(string $cmd): ?string
{
    $allowed = ['ls', 'ps', 'whoami', 'id', 'uname', 'pwd'];
    if (!in_array($cmd, $allowed, true)) {
        return null;
    }

    // экранируем и выполняем; 2>&1 — чтобы увидеть stderr
    $output = shell_exec($cmd . ' 2>&1');
    return $output === null ? '' : $output;
}