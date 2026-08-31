$(document).ready(function(){

	let modal = $('#modalNotificacao');


	$('#btnNotificacao').click(function(){

		modal[0].showModal();

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

			} else {

				console.log(resposta);

			}

		})
		.catch(function(erro){

			console.log(erro);

		});

	});


});
