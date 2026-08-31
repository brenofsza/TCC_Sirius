$(document).ready(function(){

    const modal = document.getElementById('ModalPerfil');
    const abrir = document.getElementById('editPerfil');
    const fechar = document.getElementById('fechaEditPer');
  
    abrir.addEventListener('click', () => modal.showModal());
    fechar.addEventListener('click', () => modal.close());

    $('#formEditarPerfil').on('submit', function(e) {
        e.preventDefault(); 

        const nome = $('#nome').val();
        const email = $('#email').val();
        const username = $('#username').val();
        const descricao = $('#descricao').val();

        fetch("../php/edtUsuario.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "nome=" + encodeURIComponent(nome) + 
                  "&email=" + encodeURIComponent(email) + 
                  "&username=" + encodeURIComponent(username) +
                  "&descricao=" + encodeURIComponent(descricao)
        })
        .then(response => response.text())
        .then(retorno => {
            let resposta = retorno.trim();
            console.log(resposta);
                    
            if(resposta === "OK!") {
                $('#mensagem').html("Dados editados com sucesso!").css("color", "green").fadeIn(300).delay(2000).fadeOut(400);
                modal.close(); 
                
                setTimeout(() => {
                    window.location.reload(); 
                }, 100);             

            } else if(resposta === "EMAIL_EXISTE") {
                $('#mensagem').html("Esse email já está cadastrado!").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
                
            } else if(resposta === "USER_EXISTE") {
                $('#mensagem').html("Esse username já está sendo usado!").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
                
            } else {
                $('#mensagem').html("Não foi possível editar os dados.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            }
        })
        .catch(function(erro){
            console.log(erro);
            $('#mensagem').html("Erro ao conectar.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
        });
    });
});