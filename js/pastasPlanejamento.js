$(document).ready(function(){

    let modoMateriais = "cadastro";


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

        modoMateriais = "cadastro";

        buscarPastasPlanejamento();

        $('#pastasPlanejamento').show();

        $('#materiaisPasta').hide();

        $('#modalMateriaisSalvos')[0].showModal();

    });


    $('#abrirMateriaisSalvosEditar').click(function(){

        modoMateriais = "editar";

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


            let listaMateriais;


            if(modoMateriais == "cadastro"){

                listaMateriais = '#materiaisSelecionados';

            } else {

                listaMateriais = '#materiaisSelecionadosEditar';

            }


            if($(listaMateriais + ' .material-selecionado[data-id="' + idMaterial + '"]').length == 0){

                $(listaMateriais).append(

                    '<div class="material-selecionado" data-id="' + idMaterial + '">' +

                        '<span>' + titulo + '</span>' +

                        '<button type="button" class="remover-material">Remover</button>' +

                    '</div>'

                );

            }

        });


        $('#modalMateriaisSalvos')[0].close();

    });


});
