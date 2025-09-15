MonitorGLP - SISTEMA PARA O MONITORAMENTO DE NÍVEIS DE GLP

Centro Federal de Educação Tecnológica Celso Suckow da Fonseca (CEFET-RJ), UnED Nova Friburgo

Bacharelado em Sistemas de Informação

Este projeto foi desenvolvido no primeiro semestre de 2025 como parte da disciplina de Internet das Coisas, sob a orientação da professora Helga Balbi.

URL para repositório do GitLab: https://gitlab.com/giovanni_madrignani/monitorglp


########################################################


AUTORIA

Nome: Giovanni de Oliveira Madrignani
E-mail: giovannioliveira5@gmail.com


########################################################


DESCRIÇÃO

O MonitorGLP é uma aplicação para desktop que permite aos usuários monitorar em tempo real os níveis de GLP (Gás Liquefeito de Petróleo) usando um sensor MQ-2 conectado a um Arduino Uno R3 com placa de rede Ethernet. A aplicação realiza a transferência de dados utilizando o protocolo MQTT para um servidor remoto.

O projeto também inclui um sistema de alerta por e-mail, notificando o usuário sempre que os níveis de gás ultrapassarem um limite pré-determinado.


########################################################


FUNCIONALIDADES

1. Notificação por E-mail: O usuário é avisado por e-mail quando os níveis de gás passarem de um certo ponto.

2. Leitura Contínua dos Níveis de GLP: Os níveis de gás são lidos constantemente enquanto o Arduino estiver conectado à Internet.

3. Visualização em Tempo Real: O usuário pode visualizar os níveis de gás lidos pelo sensor MQ-2 em tempo real enquanto a aplicação estiver rodando.


########################################################


ESTRUTURA DO SISTEMA

- Arduino Uno R3 com Ethernet Shield.

- MQ-2 (sensor de gás) conectado ao Arduino.

- Servidor MQTT com broker Mosquitto (instalado em uma máquina acessível remotamente).

- Aplicação Desktop com interface web.


########################################################


HARDWARE


- Arduino Uno R3

- Cabo USB-C

- Fonte de energia para Arduino (carregador de celular)

- Placa de Rede com escudo Ethernet

- Slot livre de um roteador com conexão à Internet

- Cabo Ethernet

- Sensor MQ-2

- 4 fios de conexão do Arduino para o MQ-2


########################################################


SOFTWARE 

- IDE do Arduino

- Biblioteca PubSubClient para o MQTT

- Servidor MQTT com Mosquitto configurado

- Navegador Web


########################################################


FUNCIONAMENTO 

1. O Arduino lê os valores do sensor MQ-2 conectado a ele.

2. Esses dados são enviados para o servidor MQTT usando o protocolo um broker Mosquitto.

3. A aplicação web, rodando localmente (localhost), recebe esses dados em tempo real e os exibe na interface do usuário.

4. Caso o nível de gás ultrapasse o limite configurado, a aplicação enviará um alerta por e-mail ao usuário.


########################################################


INSTRUÇÕES DE USO

1. Configuração do Broker: Utilize a máquina com o broker Mosquitto configurado. Verifique se a máquina está ligada e que a porta TCP (1183) está acessível.

2. Credenciais: No momento da conexão ao broker MQTT, use o nome de usuário e senha corretos.

3. Carregue o código do Arduino na placa usando a IDE do Arduino.

4. Conecte o Arduino à sua rede Ethernet.

5. Verifique no console da IDE se a mensagem "Conectado ao broker MQTT!" aparece. Isso confirma que a conexão foi bem-sucedida.

6. Abra a aplicação web localmente no navegador para visualizar os dados.

7. Verifique os dados em tempo real à medida que o Arduino envia informações do sensor MQ-2 para o servidor.


########################################################


LICENÇA

Este projeto está sob a Licença MIT.


########################################################