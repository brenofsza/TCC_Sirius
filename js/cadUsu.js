$(document).ready(function() {
    
    
 $('#cadastro_usu').on('submit', function(event) {
        event.preventDefault(); 
        
        var no = $('#nome').val().trim();
        var em = $('#email').val().trim();
        var se = $('#senha').val();
        var co = $('#confirmaSenha').val();
        
        
        var $msg = $('#mensagem');

        
        function exibirMensagem(texto, tempo = 2000) {
            $msg.html(texto).fadeIn(300).delay(tempo).fadeOut(400);
        }

    
        if (no === '') {
            exibirMensagem("Nome inválido!");
            return;
        }

        if (em === '') {
            exibirMensagem("E-mail inválido!");
            return;
        }

        if (se === '') {
            exibirMensagem("Senha inválida!");
            return;
        }

        if (co === '' || co !== se) {
            exibirMensagem("Confirmação de senha inválida!");
            return;
        }


        $.ajax({
            url: 'cadUsuario.php',
            type: 'POST',
            data: {
                nome: no,
                email: em,
                senha: se,
                confirmaSenha: co
            },
            success: function(response) {
                response = response.trim();
                console.log("Resposta do servidor:", response);
                
                if (response === "OK!") {
                    exibirMensagem("Cadastro realizado com sucesso!", 1000);
                    
                    setTimeout(function() {
                        window.location.href = "cadastrar.php";
                    }, 1200);

                } else if (response === "EMAIL_EXISTE") {
                    exibirMensagem("Este e-mail já está cadastrado!");
                    
                } else if (response === "SENHA_ERRO") {
                    exibirMensagem("As senhas não coincidem!");
                    
                } else {
                    exibirMensagem("Erro ao cadastrar no servidor!");
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição: ", error);
                exibirMensagem("Erro de conexão com o servidor!");
            }
        });
    });
});
