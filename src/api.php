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
                $stmt = $pdo->prepare("SELECT * FROM categorias");
                $stmt->execute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($response);
                break;
        }
        break;

    case 'productos':
        switch ($method) {
            case 'GET':
                $stmt = $pdo->prepare("SELECT * FROM productos");
                $stmt->execute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($response);

        }
        break;

    case 'promociones':
        switch ($method) {
            case 'GET':
                $stmt = $pdo->prepare("SELECT * FROM promociones");
                $stmt->execute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                echo json_encode($response);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Recurso no encontrado']);
        break;
}
