$(document).ready(function(){

    function buscarAtividadesConexoes(){

        let logado = $('#btnNotificacao').data('logado');

        if(logado == 'nao'){

            $('#atividadesConexoes').html(
                '<p>Faça login para ver as atividades das suas conexões.</p>'
            );

            return;

        }


        fetch("php/buscarAtividadesConexoes.php", {
            method: "POST"
        })
        .then(response => response.json())
        .then(atividades => {

            if(atividades.length == 0){

                $('#atividadesConexoes').html(
                    '<p>Nenhuma atividade das suas conexões.</p>'
                );

                return;

            }


            let html = "";


            atividades.forEach(function(atividade){

                html +=
                    '<div class="atividade-conexao" data-id="' + atividade.ID_MATERIAL + '">' +
                        '<h3>' + atividade.NOME_USU + ' publicou um novo material</h3>' +
                        '<p>' + atividade.TITULO_MATERIA + '</p>' +
                    '</div>';

            });


            $('#atividadesConexoes').html(html);

        })
        .catch(function(erro){

            console.log(erro);

            $('#atividadesConexoes').html(
                '<p>Erro ao carregar as atividades.</p>'
            );

        });

    }

    $(document).on('click', '.atividade-conexao', function(){

    let idMaterial = $(this).data('id');

    window.location.href = "front/material.php?id=" + idMaterial;

});

    function buscarProximasAulas(){

        let logado = $('#btnNotificacao').data('logado');

        if(logado == 'nao'){

            $('#proximasAulas').html(
                '<p>Faça login para ver suas próximas aulas.</p>'
            );

            return;

        }


        fetch("php/buscarProximasAulas.php", {
            method: "POST"
        })
        .then(response => response.json())
        .then(aulas => {

            if(aulas.length == 0){

                $('#proximasAulas').html(
                    '<p>Nenhuma próxima aula.</p>'
                );

                return;

            }


            let html = "";


            aulas.forEach(function(aula){

                let data = aula.DATA_AULA.split("-");

                let dataFormatada =
                    data[2] + "/" + data[1] + "/" + data[0];


               html +=
                '<div class="proxima-aula" data-data="' + aula.DATA_AULA + '">' +
                    '<h3>' + aula.TITULO_PLAN + '</h3>' +
                    '<p>' +
                        dataFormatada +
                        ' • ' +
                        aula.HORA_INICIO.substring(0, 5) +
                        ' - ' +
                        aula.HORA_FIM.substring(0, 5) +
                    '</p>' +
                    '<p>' +
                        aula.SALA +
                    '</p>' +
                '</div>';

            });


            $('#proximasAulas').html(html);

        })
        .catch(function(erro){

            console.log(erro);

            $('#proximasAulas').html(
                '<p>Erro ao carregar as próximas aulas.</p>'
            );

        });

    }

    $(document).on('click', '.proxima-aula', function(){

    let data = $(this).data('data');

    window.location.href = "front/planejamento.php?data=" + data;

});


    buscarAtividadesConexoes();
    buscarProximasAulas();

});