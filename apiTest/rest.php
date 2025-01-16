<?php
declare(strict_types=1);

header("Content-Type: application/json; charset=UTF-8");

require_once './controllers/Users.class.php';
require_once './controllers/Admin.class.php';

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Endpoint routing
switch ($endpoint) {
    case 'login':
        handleLogin($method);
        break;

    case 'users':
        handleUsers($method, $id);
        break;

    case 'admins':
        handleAdmins($method, $id);
        break;

    default:
        echo json_encode(["error" => "Invalid endpoint."]);
        break;
}

// Handle login requests
function handleLogin(string $method): void {
    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        if (!empty($email) && !empty($password)) {
            $user = AdminController::login($email, $password);
            echo json_encode($user);
        } else {
            echo json_encode(["success" => false, "message" => "Please provide both email and password."]);
        }
    } else {
        echo json_encode(["error" => "Invalid request method."]);
    }
}

// Handle user requests
function handleUsers(string $method, ?int $id): void {
    switch ($method) {
        case 'GET':
            $data = UserController::read($id);
            echo json_encode($data);
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);

            if (!empty($input['name']) && !empty($input['lastname']) && !empty($input['address']) && !empty($input['email'])) {
                $response = UserController::create($input['name'], $input['lastname'], $input['address'], $input['email']);
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Invalid input, provide all fields: name, lastname, address, email"]);
            }
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            if ($id && !empty($input['name']) && !empty($input['lastname']) && !empty($input['address']) && !empty($input['email'])) {
                $response = UserController::update($id, $input['name'], $input['lastname'], $input['address'], $input['email']);
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Invalid input, provide all fields; name, lastname, address, email"]);
            }
            break;

        case 'DELETE':
            if ($id) {
                $response = UserController::delete($id);
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Invalid ID."]);
            }
            break;

        default:
            echo json_encode(["error" => "Invalid request method."]);
            break;
    }
}

// Handle admin requests
function handleAdmins(string $method, ?int $id): void {
    switch ($method) {
        case 'GET':
            $response = AdminController::read($id);
            echo json_encode($response);
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $email = $input['email'] ?? '';
            $password = $input['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                $response = AdminController::create($email, $password);
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Invalid input, provide both email and password."]);
            }
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $email = $input['email'] ?? '';
            $password = $input['password'] ?? null;

            if ($id && !empty($email)) {
                $response = AdminController::update($id, $email, $password);
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Invalid input, provide a valid ID and email."]);
            }
            break;

        case 'DELETE':
            if ($id) {
                $response = AdminController::delete($id);
                echo json_encode($response);
            } else {
                echo json_encode(["error" => "Invalid ID."]);
            }
            break;

        default:
            echo json_encode(["error" => "Invalid request method."]);
            break;
    }
}
?>
