<?php
// Реализация алгоритмов сортировки

function sortInsertion(array $a): array {
    for ($i = 1; $i < count($a); $i++) {
        $key = $a[$i];
        $j = $i - 1;
        while ($j >= 0 && $a[$j] > $key) {
            $a[$j + 1] = $a[$j];
            $j--;
        }
        $a[$j + 1] = $key;
    }
    return $a;
}

function sortSelection(array $a): array {
    $n = count($a);
    for ($i = 0; $i < $n - 1; $i++) {
        $minIdx = $i;
        for ($j = $i + 1; $j < $n; $j++) {
            if ($a[$j] < $a[$minIdx]) $minIdx = $j;
        }
        if ($minIdx !== $i) {
            $tmp = $a[$i]; $a[$i] = $a[$minIdx]; $a[$minIdx] = $tmp;
        }
    }
    return $a;
}

function sortQuick(array $a): array {
    if (count($a) <= 1) return $a;
    $pivot = $a[0];
    $less = $more = $equal = [];
    foreach ($a as $x) {
        if ($x < $pivot) $less[] = $x;
        elseif ($x > $pivot) $more[] = $x;
        else $equal[] = $x;
    }
    return array_merge(sortQuick($less), $equal, sortQuick($more));
}

function sortMerge(array $a): array {
    if (count($a) <= 1) return $a;
    $mid = intdiv(count($a), 2);
    $left = sortMerge(array_slice($a, 0, $mid));
    $right = sortMerge(array_slice($a, $mid));
    $result = [];
    $i = $j = 0;
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i] <= $right[$j]) $result[] = $left[$i++];
        else $result[] = $right[$j++];
    }
    while ($i < count($left)) $result[] = $left[$i++];
    while ($j < count($right)) $result[] = $right[$j++];
    return $result;
}

function sortShell(array $a): array {
    $n = count($a);
    for ($gap = intdiv($n, 2); $gap > 0; $gap = intdiv($gap, 2)) {
        for ($i = $gap; $i < $n; $i++) {
            $tmp = $a[$i];
            $j = $i;
            while ($j >= $gap && $a[$j - $gap] > $tmp) {
                $a[$j] = $a[$j - $gap];
                $j -= $gap;
            }
            $a[$j] = $tmp;
        }
    }
    return $a;
}

/**
 * Возвращает отсортированный массив по названию алгоритма.
 * Неизвестный алгоритм → null.
 */
function applySort(string $algo, array $arr): ?array
{
    switch ($algo) {
        case 'insertion': return sortInsertion($arr);
        case 'selection': return sortSelection($arr);
        case 'quick':     return sortQuick($arr);
        case 'merge':     return sortMerge($arr);
        case 'shell':     return sortShell($arr);
        default:          return null;
    }
}