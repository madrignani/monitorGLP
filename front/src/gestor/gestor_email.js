export class GestorEmail {

  async enviarAlerta(valorGas){
    try {
      const resposta = await fetch('http://localhost:8000/enviar-email', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          valor: valorGas,
          timestamp: new Date().toISOString()
        })
      });
      if (!resposta.ok) {
        throw new Error(`Erro HTTP: ${resposta.status}`);
      }
      const resultado = await resposta.json();
      return resultado;
    } catch (erro) {
      throw erro;
    }
  }

}