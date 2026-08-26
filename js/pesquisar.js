$(document).ready(function(){

	let tipoPesquisa = "materiais";


	function pesquisar(){

		let pesquisa = $('#pesquisa').val().trim();

		if(pesquisa == ''){
			return;
		}

		fetch("../php/pesqMaterial.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "pesquisa=" + encodeURIComponent(pesquisa) +
				  "&tipo=" + encodeURIComponent(tipoPesquisa)
		})
		.then(response => response.text())
		.then(retorno => {

			$('#resultadoPesquisa').html(retorno);

		})
		.catch(function(erro){

			console.log(erro);

			$('#resultadoPesquisa').html(
				"<p>Erro ao realizar a pesquisa.</p>"
			);

		});

	}


	$('#formPesquisa').submit(function(e){

		e.preventDefault();

		pesquisar();

	});


	$('.tipoPesquisa').click(function(){

		$('.tipoPesquisa').removeClass('ativo');

		$(this).addClass('ativo');

		tipoPesquisa = $(this).data('tipo');

		pesquisar();

	});


	let parametros = new URLSearchParams(window.location.search);

	let pesquisaURL = parametros.get('q');


	if(pesquisaURL){

		pesquisar();

	}

});