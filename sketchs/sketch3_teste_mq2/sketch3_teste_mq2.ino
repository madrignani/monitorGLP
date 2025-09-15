#define MQ2_PIN 5

void setup() {
  Serial.begin(9600);
  pinMode(MQ2_PIN, INPUT);
  Serial.println("Iniciando calibração do sensor MQ-2...");
}

void loop() {
  int valor = digitalRead(MQ2_PIN);
  if (valor == LOW) {
    Serial.println("GÁS DETECTADO!");
  } else {
    Serial.println("NÍVEL DE GÁS NORMAL");
  }
  delay(1000); 
}