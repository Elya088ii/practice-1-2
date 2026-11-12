<?php
require_once __DIR__ . '/db.php';
$conn = getDbConnection();

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT filename, mime_type, file_data FROM pdf_files WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    header('Content-Type: ' . $row['mime_type']);
    header('Content-Disposition: attachment; filename="' . basename($row['filename']) . '"');
    header('Content-Length: ' . strlen($row['file_data']));
    echo $row['file_data'];
    exit;
} else {
    http_response_code(404);
    echo "Файл не найден";
}