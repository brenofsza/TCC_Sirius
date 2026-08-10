$(document).ready(function(){

  const modal = document.getElementById('ModalPerfil');
  const abrir = document.getElementById('editPerfil');
  const fechar = document.getElementById('fechaEditPer');

  abrir.addEventListener('click', () => modal.showModal());
  fechar.addEventListener('click', () => modal.close());


  });