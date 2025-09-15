<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$caminho = __DIR__ . '/ultimo.json';

if (file_exists($caminho)) {
    echo file_get_contents($caminho);
} else {
    echo json_encode(['error' => 'Arquivo não encontrado']);
}

?>