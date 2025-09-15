#include <SPI.h>
#include <Ethernet.h>
#include <PubSubClient.h>

byte mac[] = { 0xDE,0xAD,0xBE,0xEF,0xFE,0xED }; 

// IP fixo (caso DHCP falhe).
// Números devem ser ajustados conforme a rede que o Arduino estiver conectado.
// Para verificar IP: "ipconfig" (WIN) | "ip a" (LIN).
// Em caso de alteração do código, só conectar o Arduino ao PC, e dar upload denovo, substitui.
// O arduino executa sempre o ÚLTIMO CÓDIGO QUE FOI CARREGADO (UPLOAD) NELE.
IPAddress ip(192, 168, 0, 200);
IPAddress dns(8, 8, 8, 8);
IPAddress gateway(192, 168, 0, 1);
IPAddress subnet(255, 255, 255, 0);

IPAddress mqttServer(200,143,224,99);
const uint16_t mqttPort = 1183;
const char* mqttUser = "SEU_USUARIO";
const char* mqttPassword = "SUA_SENHA";

const int pinAnalog = A0;

EthernetClient ethClient;
PubSubClient client(ethClient);

void setup() {
  Serial.begin(9600);
  if (Ethernet.begin(mac) == 0) {
    Serial.println("DHCP falhou, usando IP estático");
    Ethernet.begin(mac, ip, dns, gateway, subnet);
  }
  delay(1500);
  Serial.print("IP do Arduino: "); Serial.println(Ethernet.localIP());
  client.setServer(mqttServer, mqttPort);
  conectarMQTT();
}

void loop() {
  if (!client.connected()) conectarMQTT();
  client.loop();
  int valor = analogRead(pinAnalog);
  char msg[6];
  sprintf(msg, "%d", valor);
  client.publish("nivelgas", msg);
  Serial.println(msg);
  delay(1000);
}

void conectarMQTT() {
  Serial.print("Conectando ao MQTT...");
  char clientId[32];
  snprintf(clientId, sizeof(clientId),
           "arduino-%02X%02X%02X", mac[3], mac[4], mac[5]);
  while (!client.connected()) {
    if (client.connect(clientId, mqttUser, mqttPassword)) {
      Serial.println("conectado!");
    } else {
      Serial.print("erro, rc=");
      Serial.print(client.state());
      Serial.println(" tentando em 5s");
      delay(5000);
    }
  }
}