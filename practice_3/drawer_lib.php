<?php
// Логика декодирования числа и генерации SVG

/**
 * Декодирует целое число $num в параметры фигуры через битовые операции.
 * Биты числа:
 *   биты 0-1 (маска 0b11)   — форма: 0 = круг, 1 = прямоугольник, 2 = треугольник, 3 = эллипс
 *   биты 2-3 (маска 0b1100) — цвет: 0 = красный, 1 = зелёный, 2 = синий, 3 = жёлтый
 *   биты 4-6 (маска 0b1110000) — размер (0-7), влияет на радиус/стороны
 */
function decodeShape(int $num): array
{
    $shapeBits = $num & 0b11;
    $colorBits = ($num >> 2) & 0b11;
    $sizeBits  = ($num >> 4) & 0b111;

    $shapes = ['circle', 'rect', 'polygon', 'ellipse'];
    $colors = ['red', 'green', 'blue', 'gold'];

    return [
        'shape' => $shapes[$shapeBits],
        'color' => $colors[$colorBits],
        'size'  => 20 + $sizeBits * 10, // 20..90
    ];
}

/**
 * Генерирует SVG-разметку по декодированным параметрам.
 */
function renderSvg(array $p): string
{
    $w = 400; $h = 300;
    $color = $p['color'];
    $size  = $p['size'];
    $cx = $w / 2; $cy = $h / 2;

    $svg = "<svg width='$w' height='$h' xmlns='http://www.w3.org/2000/svg'>";

    switch ($p['shape']) {
        case 'circle':
            $svg .= "<circle cx='$cx' cy='$cy' r='$size' fill='$color'/>";
            break;
        case 'rect':
            $x = $cx - $size; $y = $cy - $size;
            $svg .= "<rect x='$x' y='$y' width='" . ($size * 2) . "' height='" . ($size * 2) . "' fill='$color'/>";
            break;
        case 'polygon':
            $points = "$cx," . ($cy - $size) . " " . ($cx + $size) . "," . ($cy + $size) . " " . ($cx - $size) . "," . ($cy + $size);
            $svg .= "<polygon points='$points' fill='$color'/>";
            break;
        case 'ellipse':
            $svg .= "<ellipse cx='$cx' cy='$cy' rx='" . ($size * 1.5) . "' ry='$size' fill='$color'/>";
            break;
    }

    $svg .= "</svg>";
    return $svg;
}
