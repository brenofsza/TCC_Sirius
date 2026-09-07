$(document).ready(function(){

	let modal = $('#modalNotificacao');


	function atualizarContador(){

		let logado = $('#btnNotificacao').data('logado');

		if(logado == 'nao'){

			return;

		}


		fetch("php/contarNotificacoes.php", {
			method: "POST"
		})
		.then(response => response.text())
		.then(retorno => {

			let quantidade = parseInt(retorno.trim());

			if(quantidade > 0){

    	$('#contadorNotificacao').addClass('ativo');

		} else {

   		 $('#contadorNotificacao').removeClass('ativo');

}

		})
		.catch(function(erro){

			console.log(erro);

		});

	}


	$('#btnNotificacao').click(function(){

		let logado = $(this).data('logado');

		modal[0].showModal();


		if(logado == 'nao'){

			$('#notificacoes').html(`
				<p>Faça login para visualizar suas notificações.</p>
				<a href="front/logar.php">Entrar</a>
			`);

			return;

		}


		buscarSolicitacoes();

	});


	$('#fecharNotificacao').click(function(){

		modal[0].close();

	});


	function buscarSolicitacoes(){

		fetch("php/buscarSolicitacoes.php", {
			method: "POST"
		})
		.then(response => response.text())
		.then(retorno => {

			$('#notificacoes').html(retorno);

		})
		.catch(function(erro){

			console.log(erro);

			$('#notificacoes').html(
				"<p>Erro ao carregar as notificações.</p>"
			);

		});

	}


	$(document).on('click', '.aceitarConexao, .recusarConexao', function(){

		let idLigacao = $(this).data('id');

		let acao = '';


		if($(this).hasClass('aceitarConexao')){

			acao = 'aceitar';

		} else {

			acao = 'recusar';

		}


		fetch("php/statusConexao.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "id_ligacao=" + encodeURIComponent(idLigacao) +
				  "&acao=" + encodeURIComponent(acao)
		})
		.then(response => response.text())
		.then(retorno => {

			let resposta = retorno.trim();


			if(resposta == "ACEITA" || resposta == "RECUSADA"){

				buscarSolicitacoes();

				atualizarContador();

			} else {

				console.log(resposta);

			}

		})
		.catch(function(erro){

			console.log(erro);

		});

	});


	atualizarContador();

});
