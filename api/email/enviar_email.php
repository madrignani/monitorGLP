<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['valor'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

require __DIR__ . '/configuracao_email.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = SMTP_PORT;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
    $mail->addAddress(EMAIL_TO);
    $valorGas = $input['valor'];
    $timestamp = isset($input['timestamp']) ? $input['timestamp'] : date('c');
    $dataFormatada = date('d/m/Y H:i:s', strtotime($timestamp));
    $mail->isHTML(true);
    $mail->Subject = 'ALERTA: Nível Alto de GLP Detectado';
    $mail->Body    = "
        <h2 style='color:rgb(121, 26, 26);'>⚠️ ALERTA DE GÁS</h2>
        <p><strong>Nível de GLP detectado acima do limiar de segurança!</strong></p>
        <ul>
            <li><strong>Valor atual:</strong> {$valorGas}</li>
            <li><strong>Data/Hora:</strong> {$dataFormatada}</li>
        </ul>
        <p style='color:rgb(121, 26, 26);'><strong>Ação necessária:</strong> Verifique imediatamente o ambiente e tome as medidas de segurança apropriadas.</p>
        <hr>
        <p style='font-size: 12px; color: #636e72;'>Este é um alerta automático do Sistema de Monitoramento de GLP.</p>
    ";
    $mail->send();
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Email de alerta enviado com sucesso',
        'valor' => $valorGas,
        'timestamp' => $timestamp
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'sucesso' => false,
        'erro' => 'Falha ao enviar email: ' . $mail->ErrorInfo
    ]);
}

?>