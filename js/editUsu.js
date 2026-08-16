$(document).ready(function(){

  const modal = document.getElementById('ModalPerfil');
  const abrir = document.getElementById('editPerfil');
  const fechar = document.getElementById('fechaEditPer');

  abrir.addEventListener('click', () => modal.showModal());
  fechar.addEventListener('click', () => modal.close());

  fetch("../php/edtUsuario.php", {
    	method: "POST",
    	headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    
    body: "nome=" + encodeURIComponent(nome) + 
     	    "&email=" + encodeURIComponent(email)+ 
          "&username=" + encodeURIComponent(username)
})
        .then(response => response.text())
        .then(retorno => {
            
            let resposta = retorno.trim();
            console.log(resposta);
                    
            if(resposta == "OK!"){
                $('#mensagem').html("Dados editados com sucesso!");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
                
                
                setTimeout(() => {
                    window.location.href = "../front/perfil.php";
                });             

            } else if(resposta == "EMAIL_EXISTE"){
                $('#mensagem').html("Esse email ja está cadastrado!");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
                
            }else if(resposta == "USER_EXISTE"){
                $('#mensagem').html("Esse username ja está sendo usado!");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
				
				}else {
                $('#mensagem').html("Não foi possível editar");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
            }
        })
        .catch(function(erro){
            console.log(erro);
            $('#mensagem').html("Erro ao conectar");
            $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
        });
    });


