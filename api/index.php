<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$requisicao = $_SERVER['REQUEST_URI'];

if ($requisicao === '/leituras') {
    include __DIR__ . '/mqtt/leituras.php';
} elseif ($requisicao === '/enviar-email') {
    include __DIR__ . '/email/enviar_email.php';
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['error' => 'Rota não encontrada']);
}

?>