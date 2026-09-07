$(document).ready(function(){

	function buscarPastas(){

		fetch("../php/buscarPastas.php", {
			method: "POST"
		})
		.then(response => response.text())
		.then(retorno => {

			$('#listaPastas').html(retorno);

		})
		.catch(function(erro){

			console.log(erro);

			$('#listaPastas').html(
				"<p>Erro ao carregar as pastas.</p>"
			);

		});

	}


	$('#novaPasta').click(function(){

		$('#nomePasta').val('');

		$('#mensagemPasta').html('');

		$('#modalNovaPasta')[0].showModal();

	});


	$('#fecharNovaPasta').click(function(){

		$('#modalNovaPasta')[0].close();

	});


	$('#criarPasta').click(function(){

		let nomePasta = $('#nomePasta').val().trim();


		if(nomePasta == ''){

			$('#mensagemPasta').html(
				"Digite um nome para a pasta."
			);

			return;

		}


		fetch("../php/criarPasta.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "nome_pasta=" + encodeURIComponent(nomePasta)
		})
		.then(response => response.text())
		.then(retorno => {

			let resposta = retorno.trim();


			if(resposta == "OK!"){

				$('#mensagemPasta').html(
					"Pasta criada com sucesso!"
				);


				buscarPastas();


				setTimeout(function(){

					$('#modalNovaPasta')[0].close();

				}, 1000);


			} else if(resposta == "EXISTE"){

				$('#mensagemPasta').html(
					"Você já possui uma pasta com esse nome."
				);


			} else if(resposta == "NOME_VAZIO"){

				$('#mensagemPasta').html(
					"Digite um nome para a pasta."
				);


			} else {

				$('#mensagemPasta').html(
					"Erro ao criar a pasta."
				);

			}

		})
		.catch(function(erro){

			console.log(erro);

			$('#mensagemPasta').html(
				"Erro ao criar a pasta."
			);

		});

	});


	buscarPastas();

});