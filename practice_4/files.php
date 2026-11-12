<?php
require_once __DIR__ . '/db.php';
$conn = getDbConnection();
$result = $conn->query("SELECT id, filename, uploaded_at FROM pdf_files ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Мои PDF</title></head>
<body>
    <h1>Загруженные PDF-файлы</h1>
    <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <?= htmlspecialchars($row['filename']) ?> 
            (загружен <?= $row['uploaded_at'] ?>)
            <a href="download.php?id=<?= $row['id'] ?>">Скачать</a>
        </li>
    <?php endwhile; ?>
    </ul>
    <a href="/upload.php">Загрузить ещё</a>
</body>
</html>