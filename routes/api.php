<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

try {
    $response = match(true) {
        $method === 'POST' && $uri === '/auth/register' => fn() => (new AuthController)->register(),
        $method === 'POST' && $uri === '/auth/login'    => fn() => (new AuthController)->login(),
        $method === 'GET'  && $uri === '/usuarios'      => fn() => (new UsuarioController)->index(),
        $method === 'POST' && $uri === '/usuarios'      => fn() => (new UsuarioController)->store(),
        default => function() {
            http_response_code(404);
            echo json_encode(["error" => "Ruta no encontrada"]);
        }
    };

    $response();

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error interno",
        "detalle" => $e->getMessage() // opcional en desarrollo
    ]);
}