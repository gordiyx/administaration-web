<?php
include 'db.php';

// Funkce pro vrácení CSV formátu
function toCsv($data) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="users.csv"');
    $output = fopen('php://output', 'w');
    
    // Zápis hlavičky
    fputcsv($output, ['ID', 'Name', 'Surname', 'Email', 'Phone', 'Office']);
    
    // Zápis dat
    foreach ($data as $user) {
        fputcsv($output, $user);
    }
    fclose($output);
    exit();
}

// Zpracování požadavků
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$action = $request_uri[0];
$id = isset($request_uri[1]) ? intval($request_uri[1]) : null;


switch ($request_method) {
    case 'GET':
        if ($id === null) {
            // Vrať seznam všech uživatelů
            $result = $conn->query("SELECT * FROM users");
            $users = $result->fetch_all(MYSQLI_ASSOC);
            toCsv($users);
        } else {
            // Vrať uživatele s daným id
            $result = $conn->query("SELECT * FROM users WHERE id = $id");
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                toCsv([$user]);
            } else {
                http_response_code(404);
                echo "User not found.";
            }
        }
        break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            
            $uri = $_SERVER['REQUEST_URI'];
            $parts = explode('/', trim(parse_url($uri, PHP_URL_PATH), '/'));
            
            // rest.api.json.php/action/id
            $action = $parts[1] ?? null; // update
            $id = isset($parts[2]) ? intval($parts[2]) : null;
        
            if ($action === 'update' && $id !== null) {
                if (isset($input['name'], $input['surname'])) {
                    // upd
                    $stmt = $conn->prepare("UPDATE users SET name = ?, surname = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $input['name'], $input['surname'], $id);
                    if ($stmt->execute()) {
                        echo json_encode(['message' => 'User updated']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => $stmt->error]);
                    }
                    $stmt->close();
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid input. Required fields: name, surname']);
                }
            } else {
                // add new user
                if (isset($input['name'], $input['surname'])) {
                    $stmt = $conn->prepare("INSERT INTO users (name, surname) VALUES (?, ?)");
                    $stmt->bind_param("ss", $input['name'], $input['surname']);
                    if ($stmt->execute()) {
                        echo json_encode(['message' => 'User added']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => $stmt->error]);
                    }
                    $stmt->close();
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid input. Required fields: name, surname']);
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
                    echo "User updated.";
                } else {
                    http_response_code(400);
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                http_response_code(400);
                echo "Invalid input.";
            }
        } else {
            http_response_code(404);
            echo "User not found.";
        }
        break;

        case 'DELETE':
            // Smazání uživatele
            if ($id !== null) {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo "User deleted.";
                } else {
                    http_response_code(404);
                    echo "User not found.";
                }
                $stmt->close();
            } else {
                http_response_code(404);
                echo "User not found.";
            }
            break;
    
        default:
            http_response_code(405);
            echo "Method not allowed.";
            break;
    }

$conn->close(); // Uzavření připojení k databázi
?>
