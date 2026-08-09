$(document).ready(function(){
	$('#email').click(function(){
		if($(this).val()=="email"){
			$(this).val('');
	   }//fim do if
	}//fim da funcao anonima
	);//fim do click no objeto id=email


	$('#senha').click(function(){
	  if($(this).val()=="senha"){ 
			$(this).val('');
		}//fim do if
	}//fim da funcao anonima
	);//fim do click no objeto id=senha



$('#botaoLogar').click(function(){

  if($('#email').val()=='' || $('#email').val()=="email" 
  || $('#senha').val()=='' || $('#senha').val()=="senha"){
	
	$('#mensagem').html("Email ou senha inválidos");
	$('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
	return;

   } 
   let email = $('#email').val();
   let senha = $('#senha').val();
   
   fetch("../php/verificar.php", {

			method: "POST",
			headers:{
				"Content-Type":"application/x-www-form-urlencoded"
			},

			body: "&email=" + encodeURIComponent(email) + 
                  "&senha=" + encodeURIComponent(senha)

		})

		.then(response => response.text())

		.then(retorno => {

			console.log(retorno);

			if(retorno == "ok"){

				//$('#mensagem').html("Login realizado com sucesso");
				//$('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
				window.location.href="../index.php";

				
			}else{

				$('#mensagem').html("Email ou senha inválidos");
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


