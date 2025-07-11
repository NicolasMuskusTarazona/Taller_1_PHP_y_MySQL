<?php

require_once "db.php";

// Guarda el tipo de peticion HTTP
// que se esta haciendo: GET, POST, PUT, DELETE 
$method = $_SERVER['REQUEST_METHOD']; 

$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));// Captura la URL despues del dominio


$recurso = $uri[0]; // Guarda el primer segmento de la URL
$id = $uri[1] ?? null; // Guarda el segundo segmento de la URL si existe

header('Content-Type: application/json'); // Le dice al navegador que la respuesta será JSON

// EndPoint
if ($recurso !== 'productos' AND $recurso !== 'categorias' AND $recurso !== 'promociones') {
    http_response_code(404);
    echo json_encode([
        'error' => 'Recurso no encontrado',
        'code' => 404,
        'errorUrl' => 'https://http.cat/404'
    ]);
    exit;
}

// API

switch ($recurso) {
    case 'categorias':
        switch ($method) {
            case 'GET':
                if ($id) {
                    // Si viene un ID traer solo una categoria
                    $stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
                    $stmt->execute([$id]);
                    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($categoria) {
                        echo json_encode($categoria);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Categoria no encontrada']);
                    }
    
                } else {
                    // Si NO hay ID traer todas
                    $stmt = $pdo->prepare("SELECT * FROM categorias");
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($response);
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("INSERT INTO categorias(name) VALUES(?)");
                $stmt->execute([
                    $data['name']
                ]);
                http_response_code(201);
                $data['id'] = $pdo->lastInsertId();
                echo json_encode($data);
        }
        break;

    case 'productos':
        switch ($method) {
            case 'GET':
                if ($id) {
                    // Si viene un ID traer solo una productos
                    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
                    $stmt->execute([$id]);
                    $productos = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($productos) {
                        echo json_encode($productos);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'productos no encontrada']);
                    }
    
                } else {
                    // Si NO hay ID traer todas
                    $stmt = $pdo->prepare("SELECT * FROM productos");
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($response);
                }
                break;

        }
        break;

    case 'promociones':
        switch ($method) {
            case 'GET':
                if ($id) {
                    // Si viene un ID traer solo una promociones
                    $stmt = $pdo->prepare("SELECT * FROM promociones WHERE id = ?");
                    $stmt->execute([$id]);
                    $promociones = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($promociones) {
                        echo json_encode($promociones);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'promociones no encontrada']);
                    }
    
                } else {
                    // Si NO hay ID traer todas
                    $stmt = $pdo->prepare("SELECT * FROM promociones");
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($response);
                }
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Recurso no encontrado']);
        break;
}