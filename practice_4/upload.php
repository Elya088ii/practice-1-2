<?php
require_once __DIR__ . '/session_handler.php';
require_once __DIR__ . '/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $file = $_FILES['pdf'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $message = 'Ошибка загрузки: ' . $file['error'];
    } elseif ($file['type'] !== 'application/pdf') {
        $message = 'Разрешены только PDF-файлы.';
    } else {
        $conn = getDbConnection();
        $filename = basename($file['name']);
        $data = file_get_contents($file['tmp_name']);
        
        $stmt = $conn->prepare("INSERT INTO pdf_files (filename, mime_type, file_data) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $filename, $file['type'], $data);
        if ($stmt->execute()) {
            $message = 'Файл успешно загружен! ID: ' . $stmt->insert_id;
        } else {
            $message = 'Ошибка сохранения в БД.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Загрузка PDF</title></head>
<body>
    <h1>Загрузить PDF</h1>
    <p><?= htmlspecialchars($message) ?></p>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="pdf" accept="application/pdf" required>
        <button type="submit">Загрузить</button>
    </form>
    <a href="/files.php">Посмотреть загруженные файлы</a>
</body>
</html>