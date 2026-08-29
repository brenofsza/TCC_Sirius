$(document).ready(function(){

	let tipoPesquisa = "materiais";


	function pesquisar(){

		let pesquisa = $('#pesquisa').val().trim();
		let disciplina = $('#filtroDisci').val();
		let conteudo = $('#filtroCont').val();

		if(pesquisa == ''){
			return;
		}

		fetch("../php/pesqMaterial.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "pesquisa=" + encodeURIComponent(pesquisa) +
				  "&tipo=" + encodeURIComponent(tipoPesquisa) +
				  "&disciplina=" + encodeURIComponent(disciplina) +
				  "&conteudo=" + encodeURIComponent(conteudo)
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

		if(tipoPesquisa == "materiais"){
			$('#filtros').show();
		} else {
			$('#filtros').hide();
		}

		pesquisar();

	});


	$('#filtroDisci').change(function(){

		let disciplina = $(this).val();

		$('#filtroCont').html('<option value="">Todos os conteúdos</option>');

		if(disciplina == ''){
			$('#filtroCont').prop('disabled', true);
			pesquisar();
			return;
		}

		fetch("../php/buscarCont.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			},
			body: "nome=&disci=" + encodeURIComponent(disciplina)
		})
		.then(response => response.json())
		.then(retorno => {

			retorno.forEach(function(conteudo){

				$('#filtroCont').append(
					'<option value="' + conteudo.id + '">' + conteudo.nome + '</option>'
				);

			});

			$('#filtroCont').prop('disabled', false);

			pesquisar();

		})
		.catch(function(erro){

			console.log(erro);

		});

	});


	$('#filtroCont').change(function(){

		pesquisar();

	});


	let parametros = new URLSearchParams(window.location.search);

	let pesquisaURL = parametros.get('q');


	if(pesquisaURL){

		pesquisar();

	}


	$('#filtros').show();


	fetch("../php/buscarDisci.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/x-www-form-urlencoded"
		},
		body: "nome="
	})
	.then(response => response.json())
	.then(retorno => {

		retorno.forEach(function(disciplina){

			$('#filtroDisci').append(
				'<option value="' + disciplina.id + '">' + disciplina.nome + '</option>'
			);

		});

	})
	.catch(function(erro){

		console.log(erro);

	});

});