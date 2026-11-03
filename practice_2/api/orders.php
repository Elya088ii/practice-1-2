<?php
// api/orders.php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../db.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn = getDbConnection();
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM orders WHERE id = $id");
            $order = $result->fetch_assoc();
            echo $order ? json_encode($order) : json_encode(["message" => "Order not found"]);
        } else {
            $result = $conn->query("SELECT * FROM orders");
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($orders);
        }
        break;

    case 'POST':
        if (!isset($input['user_id'], $input['product_name'], $input['price'])) {
            http_response_code(400);
            echo json_encode(["error" => "user_id, product_name and price are required"]);
            break;
        }
        $user_id = intval($input['user_id']);
        $product_name = $conn->real_escape_string($input['product_name']);
        $price = floatval($input['price']);
        if ($conn->query("INSERT INTO orders (user_id, product_name, price) VALUES ($user_id, '$product_name', $price)")) {
            http_response_code(201);
            echo json_encode(["message" => "Order created", "id" => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'PUT':
        if (!isset($_GET['id'], $input['product_name'], $input['price'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID, product_name and price are required"]);
            break;
        }
        $id = intval($_GET['id']);
        $product_name = $conn->real_escape_string($input['product_name']);
        $price = floatval($input['price']);
        $conn->query("UPDATE orders SET product_name='$product_name', price=$price WHERE id=$id");
        echo json_encode(["message" => "Order updated"]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID is required"]);
            break;
        }
        $id = intval($_GET['id']);
        $conn->query("DELETE FROM orders WHERE id=$id");
        echo json_encode(["message" => "Order deleted"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
$conn->close();