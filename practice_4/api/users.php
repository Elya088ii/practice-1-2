<?php
// api/users.php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../db.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn = getDbConnection();
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM users WHERE id = $id");
            $user = $result->fetch_assoc();
            echo $user ? json_encode($user) : json_encode(["message" => "User not found"]);
        } else {
            $result = $conn->query("SELECT * FROM users");
            $users = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($users);
        }
        break;

    case 'POST':
        if (!isset($input['name'], $input['email'])) {
            http_response_code(400);
            echo json_encode(["error" => "Name and email are required"]);
            break;
        }
        $name = $conn->real_escape_string($input['name']);
        $email = $conn->real_escape_string($input['email']);
        if ($conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')")) {
            http_response_code(201);
            echo json_encode(["message" => "User created", "id" => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'PUT':
        if (!isset($_GET['id'], $input['name'], $input['email'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID, name and email are required"]);
            break;
        }
        $id = intval($_GET['id']);
        $name = $conn->real_escape_string($input['name']);
        $email = $conn->real_escape_string($input['email']);
        $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
        echo json_encode(["message" => "User updated"]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID is required"]);
            break;
        }
        $id = intval($_GET['id']);
        $conn->query("DELETE FROM users WHERE id=$id");
        echo json_encode(["message" => "User deleted"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
$conn->close();