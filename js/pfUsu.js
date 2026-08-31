$(document).ready(function(){

	let idUsuario = $('#idUsuario').val();


	function buscarMateriais(){

		fetch("../php/MateriaisUsu.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_usuario=" + encodeURIComponent(idUsuario) +
				  "&tipo=publico"
		})
		.then(response => response.text())
		.then(retorno => {

			$('#materiaisPublicos').html(retorno);

		})
		.catch(function(erro){

			console.log(erro);

			$('#materiaisPublicos').html(
				"<p>Erro ao carregar os materiais.</p>"
			);

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


	function verificarConexao(){

		fetch("../php/buscarConexao.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_usuario=" + encodeURIComponent(idUsuario)
		})
		.then(response => response.text())
		.then(retorno => {

			let resposta = retorno.trim();

			if(resposta == "PENDENTE"){

				$('#ligarUsuario').html("Conexão pendente");

			} else if(resposta == "ACEITA"){

				$('#ligarUsuario').html("Conectado");

			} else {

				$('#ligarUsuario').html("Conectar");

			}

		})
		.catch(function(erro){

			console.log(erro);

		});

	}


	$('#ligarUsuario').click(function(){

		fetch("../php/conectarUsu.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_usuario=" + encodeURIComponent(idUsuario)
		})
		.then(response => response.text())
		.then(retorno => {

			let resposta = retorno.trim();

			if(resposta == "OK!"){

                $('#ligarUsuario').html("Conexão pendente");

            } else if(resposta == "CANCELADO"){

                $('#ligarUsuario').html("Conectar");

            } else if(resposta == "ACEITA"){

                $('#ligarUsuario').html("Conectado");

            } else if(resposta == "DESFEITO"){

                $('#ligarUsuario').html("Conectar");

            } else {

                console.log(resposta);

}

		})
		.catch(function(erro){

			console.log(erro);

		});

	});


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


	buscarMateriais();

	verificarConexao();

	contarConexoes();

});