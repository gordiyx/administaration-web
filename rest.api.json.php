<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include 'db.php';

// vrácení JSON formátu
function toJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$action = $request_uri[0];
$id = isset($request_uri[1]) ? intval($request_uri[1]) : null;


switch ($request_method) {
    case 'GET':
        if ($id === null) {
            // seznam všech uživatelů
            $result = $conn->query("SELECT * FROM users");
            $users = $result->fetch_all(MYSQLI_ASSOC);
            toJson($users);
        } else {
            // uživatele s daným id
            $result = $conn->query("SELECT * FROM users WHERE id = $id");
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                toJson([$user]);
            } else {
                http_response_code(404);
                toJson(['message' => 'User not found']);
            }
        }
        break;

        case 'POST':
           
            $input = json_decode(file_get_contents('php://input'), true);
        
            $uri = $_SERVER['REQUEST_URI'];
            $parts = explode('/', trim(parse_url($uri, PHP_URL_PATH), '/'));
            
            $action = $parts[1] ?? null; // update
            $id = isset($parts[2]) ? intval($parts[2]) : null; // id
        
            // Ожидается, что путь будет иметь формат /update/id
            if ($action === 'update' && $id !== null) {
                if (isset($input['name'], $input['surname'])) {
                    // upd users
                    $stmt = $conn->prepare("UPDATE users SET name = ?, surname = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $input['name'], $input['surname'], $id);
                    if ($stmt->execute()) {
                        toJson(['message' => 'User updated']);
                    } else {
                        http_response_code(400);
                        toJson(['error' => $stmt->error]);
                    }
                    $stmt->close();
                } else {
                    http_response_code(400);
                    toJson(['error' => 'Invalid input. Required fields: name, surname']);
                }
            } else {
                // if not update -> insert
                if (isset($input['name'], $input['surname'])) {
                    $stmt = $conn->prepare("INSERT INTO users (name, surname) VALUES (?, ?)");
                    $stmt->bind_param("ss", $input['name'], $input['surname']);
                    if ($stmt->execute()) {
                        toJson(['message' => 'User added']);
                    } else {
                        http_response_code(400);
                        toJson(['error' => $stmt->error]);
                    }
                    $stmt->close();
                } else {
                    http_response_code(400);
                    toJson(['error' => 'Invalid input. Required fields: name, surname']);
                }
            }
            break;
        
        
    case 'PUT':
        // upd user
        if ($id !== null) {
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['name'], $input['surname'])) {
                $stmt = $conn->prepare("UPDATE users SET name = ?, surname = ? WHERE id = ?");
                $stmt->bind_param("ssi", $input['name'], $input['surname'], $id);
                if ($stmt->execute()) {
                    toJson(['message' => 'User updated']);
                } else {
                    http_response_code(400);
                    toJson(['error' => $stmt->error]);
                }
                $stmt->close();
            } else {
                http_response_code(400);
                toJson(['error' => 'Invalid input']);
            }
        } else {
            http_response_code(404);
            toJson(['message' => 'User not found']);
        }
        break;


        case 'DELETE':
            // Smazání uživatele
            if ($id !== null) {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    toJson(['message' => 'User deleted']);
                } else {
                    http_response_code(404);
                    toJson(['message' => 'User not found']);
                }
                $stmt->close();
            } else {
                http_response_code(404);
                toJson(['message' => 'User not found']);
            }
            break;
    
        default:
            http_response_code(405);
            toJson(['error' => 'Method not allowed']);
            break;
    }
    

$conn->close(); // Uzavření připojení k databázi
?>
