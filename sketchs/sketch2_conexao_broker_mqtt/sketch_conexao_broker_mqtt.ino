#include <SPI.h>
#include <Ethernet.h>
#include <PubSubClient.h>

// Defina seu MAC (pode manter esse)
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };

// Defina o IP do broker MQTT e a porta
IPAddress mqttServer(200, 143, 224, 99);
const int mqttPort = 1183;

// Login e senha Mosquitto
const char* mqttUser = "SEU_USUARIO";
const char* mqttPassword = "SUA_SENHA";

// Ethernet e MQTT clients
EthernetClient ethClient;
PubSubClient client(ethClient);

void setup() {
  Serial.begin(9600);
  Ethernet.begin(mac);
  delay(1500);  // Aguarda Ethernet

  client.setServer(mqttServer, mqttPort);

  Serial.print("Conectando ao broker MQTT...");

  if (client.connect("arduinoClient", mqttUser, mqttPassword)) {
    Serial.println("Conectado!");
    client.publish("teste/topico", "Olá, MQTT!");
  } else {
    Serial.print("Falha na conexão. Código: ");
    Serial.println(client.state());
  }
}

void loop() {
  client.loop();  // Mantém a conexão MQTT ativa
}
