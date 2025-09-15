import { ControladoraStatusDinamico } from "../controladora/controladora_status_dinamico.js";

export class VisaoStatusDinamico {

  constructor() {
    this.controladora = new ControladoraStatusDinamico(this);
    this.status = document.getElementById('status');
    this.valorLeitura = document.getElementById('valor');
  }

  iniciar() {
    if (!this.intervalo) {
      this.controladora.buscarLeitura();
      this.intervalo = setInterval(
        () => this.controladora.buscarLeitura(),
        5000
      );
      this.status.style.display = 'block';
      this.status.style.opacity = '1';
      this.valorLeitura.textContent = '';
    }
  }

  parar() {
    if (this.intervalo) {
      clearInterval(this.intervalo);
      this.intervalo = null;
    }
    this.status.style.display = 'none';
    this.valorLeitura.textContent = '';
  }


  exibirStatusNormal() {
    this.status.className = 'normal';
    this.status.innerHTML = '✅ NÍVEL DE GÁS NORMAL';
  }

  exibirStatusAlerta() {
    this.status.className = 'alerta';
    this.status.innerHTML = '⚠️ GÁS DETECTADO';
  }

  exibirErro() {
    this.valorLeitura.textContent = 'ERRO';
    this.status.className = 'erro';
    this.status.innerHTML = '❌ FALHA NA LEITURA';  
  }

  atualizarLeitura(valor) {
    this.valorLeitura.textContent = valor;
  }

}