<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/acesso.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

$server   = '200.143.224.99';
$port     = 1183;
$clientId = 'phpPublisher';
$username = MQTT_USUARIO;
$password = MQTT_SENHA;

$connectionSettings = (new ConnectionSettings())
    ->setUsername($username)
    ->setPassword($password);

$mqtt = new MqttClient($server, $port, $clientId);
$mqtt->connect($connectionSettings, true);
$topico = 'teste/topico';
$mensagem = 'Mensagem de teste via PHP';

$mqtt->publish($topico, $mensagem, 0);
echo "Mensagem publicada no tópico '$topico'.\n";
$mqtt->disconnect();

?>