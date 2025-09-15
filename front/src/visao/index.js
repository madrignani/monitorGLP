import { VisaoStatusDinamico } from './visao_status_dinamico.js';

const visao = new VisaoStatusDinamico();

document.getElementById('iniciar').addEventListener('click', () => visao.iniciar());
document.getElementById('parar').addEventListener('click', () => visao.parar());