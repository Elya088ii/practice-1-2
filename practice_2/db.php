<?php
// db.php
function getDbConnection() {
    $host = 'db';
    $user = 'user';
    $pass = 'password';
    $dbname = 'appDB';

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
        exit;
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}