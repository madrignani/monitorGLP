import { GestorLeitura } from '../gestor/gestor_leitura.js';
import { GestorEmail } from '../gestor/gestor_email.js';

export class ControladoraStatusDinamico {

  constructor(visao) {
    this.visao = visao;
    this.limiar = 750;
    this.gestor = new GestorLeitura();
    this.gestorEmail = new GestorEmail();
    this.estadoAlto = false;
    this.ultimoEmailEnviado = null;
  }

  async buscarLeitura() {
    try {
        const valor = await this.gestor.buscar();
        this.visao.atualizarLeitura(valor); 
        if (valor >= this.limiar) {
            this.visao.exibirStatusAlerta();
            await this.gerenciarAlertas(valor);
        } else {
            this.visao.exibirStatusNormal();
            this.estadoAlto = false;
            this.ultimoEmailEnviado = null;
        }
    } catch (erro) {
      console.error("Erro ao obter leitura:", erro);
      this.visao.exibirErro();
    }
  }

  async gerenciarAlertas(valor) {
    const agora = Date.now();
    if (!this.estadoAlto) {
        this.estadoAlto = true;
        await this.gestorEmail.enviarAlerta(valor);
        this.ultimoEmailEnviado = agora;
    } else if ( this.ultimoEmailEnviado && (agora - this.ultimoEmailEnviado >= 120000) ) {
        await this.gestorEmail.enviarAlerta(valor);
        this.ultimoEmailEnviado = agora;
    }
  }

}