$(document).ready(function(){
	$('#usuario').click(function(){
		if($(this).val()=="usuario"){
			$(this).val('');
	   }//fim do if
	}//fim da funcao anonima
	);//fim do click no objeto id=usuario


	$('#senha').click(function(){
	  if($(this).val()=="senha"){
			$(this).val('');
		}//fim do if
	}//fim da funcao anonima
	);//fim do click no objeto id=senha



$('#botaoCadastrar').click(function(){
	
  if($('#usuario').val()=='' || $('#usuario').val()=="usuario" 
  || $('#senha').val()=='' || $('#senha').val()=="senha"){
	
	$('#mensagem').html("Usuário ou senha inválidos");
	$('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
	return;

   } 
   let usuario = $('#usuario').val();
   let senha = $('#senha').val();
   let email = $('#email').val();
   console.log(email);
   
   fetch("cadUsuario.php", {

			method: "POST",
			headers:{
				"Content-Type":"application/x-www-form-urlencoded"
			},

			body: "uuario=" + usuario + "&senha=" + senha + "&email=" +email

		})

		.then(response => response.text())

		.then(retorno => {

			console.log(retorno);
                
			if(retorno == "OK!"){

				$('#mensagem').html("Cadastro realizado com sucesso");
				$('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
				window.location.href = "cadastrar.php";


			}else if(retorno == "SENHA_ERRO"){

                $('#mensagem').html("As senhas são diferentes!");
				$('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
                window.location.href = "cadastrar.php";
            }

            else if(retorno=="EMAIL_EXISTE"){

                $('#mensagem').html("Esse email ja está cadastrado!");
				$('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
                window.location.href = "cadastrar.php";

            }
                
			else{

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


