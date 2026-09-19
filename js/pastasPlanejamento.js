$(document).ready(function(){

    function buscarPastasPlanejamento(){

        fetch("../php/buscarPastasPlanejamento.php", {
            method: "POST"
        })
        .then(response => response.text())
        .then(retorno => {

            $('#listaPastasPlanejamento').html(retorno);

        })
        .catch(function(erro){

            console.log(erro);

            $('#listaPastasPlanejamento').html(
                "<p>Erro ao carregar as pastas.</p>"
            );

        });

    }


    $('#abrirMateriaisSalvos').click(function(){

        buscarPastasPlanejamento();

        $('#pastasPlanejamento').show();

        $('#materiaisPasta').hide();

        $('#modalMateriaisSalvos')[0].showModal();

    });


    $('#fecharMateriaisSalvos').click(function(){

        $('#modalMateriaisSalvos')[0].close();

    });


    $(document).on('click', '.pasta-planejamento', function(){

        let idPasta = $(this).data('id');

        fetch("../php/buscarMatPlanejamentoPasta.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_pasta=" + encodeURIComponent(idPasta)
        })
        .then(response => response.text())
        .then(retorno => {

            $('#pastasPlanejamento').hide();

            $('#materiaisPasta').show();

            $('#listaMateriaisPasta').html(retorno);

        })
        .catch(function(erro){

            console.log(erro);

            $('#listaMateriaisPasta').html(
                "<p>Erro ao carregar os materiais.</p>"
            );

        });

    });


    $('#voltarPastas').click(function(){

        $('#materiaisPasta').hide();

        $('#pastasPlanejamento').show();

    });


    $('#adicionarMateriaisAula').click(function(){

        $('.material-pasta-checkbox:checked').each(function(){

            let idMaterial = $(this).val();

            let titulo = $(this).closest('.material-pasta-planejamento')
                .find('h3')
                .text();

            if($('#materiaisSelecionados .material-selecionado[data-id="' + idMaterial + '"]').length == 0){

                $('#materiaisSelecionados').append(

                    '<div class="material-selecionado" data-id="' + idMaterial + '">' +

                        '<span>' + titulo + '</span>' +

                        '<button type="button" class="remover-material">Remover</button>' +

                    '</div>'

                );

            }

        });


        $('#modalMateriaisSalvos')[0].close();

    });

let idAulaExcluir = null;


$(document).on('click', '.excluir-aula', function(){

    idAulaExcluir = $(this).data('id');

    $('#modalExcluirAula')[0].showModal();

});


$('#fecharExcluirAula, #cancelarExcluirAula').click(function(){

    $('#modalExcluirAula')[0].close();

    idAulaExcluir = null;

});

   $('#confirmarExcluirAula').click(function(){

        if(idAulaExcluir == null){

            return;

        }


        fetch("../php/excPlanejamento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_planejamento=" + encodeURIComponent(idAulaExcluir)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();


            if(resposta == "OK!"){

                $('#modalExcluirAula')[0].close();

                idAulaExcluir = null;

                mostrarCalendario();

            } else {

                console.log(resposta);

            }

        })
        .catch(function(erro){

            console.log(erro);

        });

    });

});