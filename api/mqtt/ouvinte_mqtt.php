<?php

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../conexao.php';
require __DIR__ . '/acesso.php';


use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;


$server   = '200.143.224.99';
$port     = 1183;
$clientId = 'phpSubscriber-' . uniqid();
$username = MQTT_USUARIO;
$password = MQTT_SENHA;


$connectionSettings = (new ConnectionSettings())
    ->setUsername($username)
    ->setPassword($password);

$mqtt = new MqttClient($server, $port, $clientId);
$mqtt->connect($connectionSettings, true);
$topic = 'nivelgas';
echo "Ouvindo mensagens em '$topic'...\n";


$mqtt->subscribe($topic, function (string $topic, string $message) {
    echo "[$topic] $message\n";
    $message = trim($message);
    if (is_numeric($message)) {
        $valor = (int) $message;
        $dataJson = [
            'topico'    => $topic,
            'valor'     => $valor,
            'timestamp' => date('c')
        ];
        $jsonPath = __DIR__ . '/ultimo.json';
        file_put_contents($jsonPath, json_encode($dataJson));

        try {
            $json = file_get_contents($jsonPath);
            $data = json_decode($json, true);
            $valorFromJson     = isset($data['valor'])    ? (int)$data['valor']    : null;
            $timestampFromJson = isset($data['timestamp']) ? $data['timestamp']      : null;
            if ($valorFromJson !== null && $timestampFromJson !== null) {
                $pdo = Conexao::conexao();
                $dataHora = date('Y-m-d H:i:s', strtotime($timestampFromJson));
                $status = $valorFromJson > 750 ? 'NIVEL_PERIGOSO' : 'NIVEL_NORMAL';
                $stmt = $pdo->prepare(
                    'INSERT INTO ultimas_leituras (valor, data_hora, statusLeitura) VALUES (?, ?, ?)'
                );
                $resultado = $stmt->execute([$valorFromJson, $dataHora, $status]);
                if ($resultado) {
                    $pdo->exec(
                        "DELETE FROM ultimas_leituras
                         WHERE id < (
                             SELECT id FROM (
                                 SELECT id
                                 FROM ultimas_leituras
                                 ORDER BY data_hora DESC
                                 LIMIT 1 OFFSET 199
                             ) AS tmp
                         )"
                    );
                }
            }
        } catch (PDOException $e) {
            error_log("Erro no banco: " . $e->getMessage());
        }
    } else {
        error_log("Valor inválido: " . $message);
    }
}, 0);


$mqtt->loop(true);
$mqtt->disconnect();