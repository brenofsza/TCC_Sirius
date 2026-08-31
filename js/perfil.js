$(document).ready(function(){

	let idUsuario = $('#idUsuario').val();


	function buscarMateriais(tipo){

		fetch("../php/MateriaisUsu.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_usuario=" + encodeURIComponent(idUsuario) +
				  "&tipo=" + encodeURIComponent(tipo)
		})
		.then(response => response.text())
		.then(retorno => {

			if(tipo == "publico"){

				$('#materiaisPublicos').html(retorno);

			} else if(tipo == "privado"){

				$('#materiaisPrivados').html(retorno);

			}

		})
		.catch(function(erro){

			console.log(erro);

			if(tipo == "publico"){

				$('#materiaisPublicos').html(
					"<p>Erro ao carregar os materiais.</p>"
				);

			} else {

				$('#materiaisPrivados').html(
					"<p>Erro ao carregar os materiais.</p>"
				);

			}

		});

	}


	function contarConexoes(){

		fetch("../php/contarConexoes.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_usuario=" + encodeURIComponent(idUsuario)
		})
		.then(response => response.text())
		.then(retorno => {

			let quantidade = parseInt(retorno);

			if(quantidade == 1){

				$('#qtdConexoes').text("1 conexão");

			} else {

				$('#qtdConexoes').text(quantidade + " conexões");

			}

		})
		.catch(function(erro){

			console.log(erro);

		});

	}


	$('#qtdConexoes').click(function(){

		$('#modalConexoes')[0].showModal();

		$('#listaConexoes').html("Carregando...");


		fetch("../php/modalConexao.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_usuario=" + encodeURIComponent(idUsuario)
		})
		.then(response => response.text())
		.then(retorno => {

			$('#listaConexoes').html(retorno);

		})
		.catch(function(erro){

			console.log(erro);

			$('#listaConexoes').html(
				"<p>Erro ao carregar as conexões.</p>"
			);

		});

	});


	$('#fecharConexoes').click(function(){

		$('#modalConexoes')[0].close();

	});


	$('.abaMaterial').click(function(){

		$('.abaMaterial').removeClass('ativa');

		$(this).addClass('ativa');

		let tipo = $(this).data('tipo');


		if(tipo == "publico"){

			$('#materiaisPublicos').show();
			$('#materiaisPrivados').hide();

		} else if(tipo == "privado"){

			$('#materiaisPublicos').hide();
			$('#materiaisPrivados').show();

		}

	});


	buscarMateriais("publico");

	buscarMateriais("privado");

	contarConexoes();

});