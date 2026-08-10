$(document).ready(function(){
	$('#nome').click(function(){
		if($(this).val()=="nome"){
			$(this).val('');
	   }//fim do if
	}//fim da funcao anonima
	);//fim do click no objeto id=nome


	$('#senha').click(function(){
	  if($(this).val()=="senha"){
			$(this).val('');
		}//fim do if
	}//fim da funcao anonima
	);//fim do click no objeto id=senha


    const mostrar = document.getElementById('mostrar');
	const senha = document.getElementById('senha');
	const confirmaSenha = document.getElementById('confirmaSenha');

	mostrar.addEventListener('change', function() {
        
        const tipo = this.checked ? 'text' : 'password';
        
        senha.type = tipo;
        confirmaSenha.type = tipo;
    });

    $('#botaoCadastrar').click(function(e){
        
        
        e.preventDefault(); 
        
        if($('#nome').val()=='' || $('#nome').val()=="nome" 
        || $('#senha').val()=='' || $('#senha').val()=="senha"){
        
            $('#mensagem').html("Usuário ou senha inválidos");
            $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
            return;
        } 

		if($('#username').val()=='' || $('#username').val()=="username"){
        
            $('#mensagem').html("Complete totalmente os dados");
            $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
            return;
        } 

    	if($('#email').val().indexOf('@') === -1 ) {
       	 $('#mensagem').html("Insira um endereço de e-mail válido.");
       	 $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
        return;
    }
        
        let nome = $('#nome').val().trim();
        let senha = $('#senha').val();
        let email = $('#email').val().trim();
		let confirmaSenha = $('#confirmaSenha').val(); 
		let username = $('#username').val().trim();
        console.log(email);
        
        fetch("../php/cadUsuario.php", {
    	method: "POST",
    	headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    
    body: "nome=" + encodeURIComponent(nome) + 
     	  "&email=" + encodeURIComponent(email) + 
          "&senha=" + encodeURIComponent(senha) + 
          "&username=" + encodeURIComponent(username) +
          "&confirmaSenha=" + encodeURIComponent(confirmaSenha)
})
        .then(response => response.text())
        .then(retorno => {
            
            let resposta = retorno.trim();
            console.log(resposta);
                    
            if(resposta == "OK!"){
                $('#mensagem').html("Cadastro realizado com sucesso");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
                
                
                setTimeout(() => {
                    window.location.href = "../front/cadastrar.php";
                }, 2500);

            } else if(resposta == "SENHA_ERRO"){
                $('#mensagem').html("As senhas são diferentes!");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
               

            } else if(resposta == "EMAIL_EXISTE"){
                $('#mensagem').html("Esse email ja está cadastrado!");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
                
            }else if(resposta == "USER_EXISTE"){
                $('#mensagem').html("Esse username ja está sendo usado!");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
				
				}else {
                $('#mensagem').html("Não foi possível cadastro");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
            }
        })
        .catch(function(erro){
            console.log(erro);
            $('#mensagem').html("Erro ao conectar");
            $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
        });
    });
});
