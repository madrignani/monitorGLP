export class GestorLeitura {

  async buscar() {
    const resposta = await fetch('http://localhost:8000/leituras', { 
      cache: 'no-store'
    });
    if ( !resposta.ok ) {
      throw new Error( `Erro HTTP: ${resposta.status}`);
    }
    const dados = await resposta.json();
    return dados.valor;
  }

}