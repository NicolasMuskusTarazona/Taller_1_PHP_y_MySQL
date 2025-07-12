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
                $stmt = $pdo->prepare("INSERT INTO categorias(nombre) VALUES(?)");
                $stmt->execute([
                    $data['nombre']
                ]);
                http_response_code(201);
                $data['id'] = $pdo->lastInsertId();
                echo json_encode($data);

                break;
                
            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/400']);
                    exit;
                }
                
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE categorias SET id=?, nombre=? WHERE id=?");
                $stmt->execute([
                    $data['id'],
                    $data['nombre'],
                    $id,
                ]);
                break;

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

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("INSERT INTO productos(nombre,precio, categoria_id) VALUES(?,?,?)");
                $stmt->execute([
                    $data['nombre'], $data['precio'], $data['categoria_id']
                ]);
                http_response_code(201);
                $data['id'] = $pdo->lastInsertId();
                echo json_encode($data);

                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/400']);
                    exit;
                }
                
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE productos SET id=?, nombre=?, precio=?, categoria_id=? WHERE id=?");
                $stmt->execute([
                    $data['id'],
                    $data['nombre'],
                    $data['precio'],
                    $data['categoria_id'],
                    $id,
                ]);
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
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("INSERT INTO promociones(descripcion,descuento, producto_id) VALUES(?,?,?)");
                $stmt->execute([
                    $data['descripcion'], $data['descuento'], $data['producto_id']
                ]);
                http_response_code(201);
                $data['id'] = $pdo->lastInsertId();
                echo json_encode($data);
            
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/400']);
                    exit;
                }
                
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE promociones SET id=?, descripcion=?, descuento=?, producto_id=? WHERE id=?");
                $stmt->execute([
                    $data['id'],
                    $data['descripcion'],
                    $data['descuento'],
                    $data['producto_id'],
                    $id,
                ]);
                break;
    
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Recurso no encontrado']);
        break;
}