$(document).ready(function(){

    let dataAtual = new Date();

    let mesAtual = dataAtual.getMonth();

    let anoAtual = dataAtual.getFullYear();


    function buscarPlanejamentos(){

        fetch("../php/buscarPlanejamento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "mes=" + encodeURIComponent(mesAtual + 1) +
                  "&ano=" + encodeURIComponent(anoAtual)
        })
        .then(response => response.json())
        .then(aulas => {

            $('.dia').each(function(){

                let dia = $(this).text();

                if(dia == ''){

                    return;

                }


                let possuiAula = aulas.some(function(aula){

                    let data = aula.DATA_AULA.split('-');

                    return parseInt(data[2]) == parseInt(dia);

                });


                if(possuiAula){

                    $(this).addClass('tem-aula');

                }

            });

        })
        .catch(function(erro){

            console.log(erro);

        });

    }


    function buscarAulasDia(dia){

        let mes = String(mesAtual + 1).padStart(2, '0');

        let diaFormatado = String(dia).padStart(2, '0');

        let data = anoAtual + "-" + mes + "-" + diaFormatado;


        fetch("../php/buscarAulasDia.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "data=" + encodeURIComponent(data)
        })
        .then(response => response.json())
        .then(aulas => {

            $('#tituloAulasDia').html(
                "Aulas do dia " + diaFormatado + "/" + mes + "/" + anoAtual
            );


            if(aulas.length == 0){

                $('#listaAulasDia').html(
                    "<p>Nenhuma aula planejada para este dia.</p>"
                );

                return;

            }


            $('#listaAulasDia').html('');


            aulas.forEach(function(aula){

                $('#listaAulasDia').append(

                    '<div class="aula">' +

                        '<h3>' +
                            htmlspecialchars(aula.TITULO_PLAN) +
                        '</h3>' +

                        '<p>' +
                            aula.HORA_INICIO.substring(0, 5) +
                            ' - ' +
                            aula.HORA_FIM.substring(0, 5) +
                        '</p>' +

                        '<p>' +
                            htmlspecialchars(aula.SALA) +
                        '</p>' +

                        '<p>' +
                            htmlspecialchars(aula.ASSUNTO || '') +
                        '</p>' +

                    '</div>'

                );

            });

        })
        .catch(function(erro){

            console.log(erro);

            $('#listaAulasDia').html(
                "<p>Erro ao carregar as aulas.</p>"
            );

        });

    }


    function buscarMateriais(){

        let pesquisa = $('#pesquisaMaterial').val().trim();


        if(pesquisa == ''){

            $('#resultadoMateriais').html('');

            return;

        }


        fetch("../php/buscarMateriaisAula.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "pesquisa=" + encodeURIComponent(pesquisa)
        })
        .then(response => response.json())
        .then(materiais => {

            $('#resultadoMateriais').html('');


            if(materiais.length == 0){

                $('#resultadoMateriais').html(
                    "<p>Nenhum material encontrado.</p>"
                );

                return;

            }


            materiais.forEach(function(material){

                $('#resultadoMateriais').append(

                    '<div class="resultado-material">' +

                        '<div>' +

                            '<h3>' +
                                htmlspecialchars(material.TITULO_MATERIA) +
                            '</h3>' +

                            '<p>' +
                                htmlspecialchars(material.NOME_DISCI) +
                                ' • ' +
                                htmlspecialchars(material.NOME_CONTEUDO) +
                            '</p>' +

                        '</div>' +

                        '<div>' +

                            '<button type="button" class="ver-material" ' +
                                'data-id="' + material.ID_MATERIAL + '">' +
                                'Ver material' +
                            '</button>' +

                            '<button type="button" class="adicionar-material" ' +
                                'data-id="' + material.ID_MATERIAL + '">' +
                                'Adicionar à aula' +
                            '</button>' +

                        '</div>' +

                    '</div>'

                );

            });

        })
        .catch(function(erro){

            console.log(erro);

            $('#resultadoMateriais').html(
                "<p>Erro ao buscar materiais.</p>"
            );

        });

    }


    function htmlspecialchars(texto){

        if(!texto){

            return '';

        }

        return $('<div>').text(texto).html();

    }


    $('#pesquisaMaterial').on('input', function(){

        buscarMateriais();

    });


    $(document).on('click', '.ver-material', function(){

        let idMaterial = $(this).data('id');


        fetch("../php/materialModalAula.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_material=" + encodeURIComponent(idMaterial)
        })
        .then(response => response.json())
        .then(material => {

            if(!material.ID_MATERIAL){

                $('#conteudoMaterial').html(
                    "<p>Erro ao carregar o material.</p>"
                );

                return;

            }


            let caminhoArquivo = "../" + material.CAMINHO_ARQUIVO;


            let conteudo =

                '<h2>' +
                    htmlspecialchars(material.TITULO_MATERIA) +
                '</h2>' +

                '<p><strong>Disciplina:</strong> ' +
                    htmlspecialchars(material.NOME_DISCI) +
                '</p>' +

                '<p><strong>Conteúdo:</strong> ' +
                    htmlspecialchars(material.NOME_CONTEUDO) +
                '</p>' +

                '<p><strong>Nível:</strong> ' +
                    htmlspecialchars(material.NOME_NIVEL) +
                '</p>';


            if(material.DESCRICAO_MATERIA){

                conteudo +=

                    '<p><strong>Descrição:</strong> ' +
                        htmlspecialchars(material.DESCRICAO_MATERIA) +
                    '</p>';

            }


            conteudo +=

                '<div class="autor-material">' +

                    '<p><strong>Publicado por:</strong> ' +
                        htmlspecialchars(material.NOME_USU) +
                    '</p>' +

                '</div>' +

                '<p><strong>Data:</strong> ' +
                    new Date(material.DATA_CAD).toLocaleDateString('pt-BR') +
                '</p>' +

                '<p><strong>Arquivo:</strong> ' +
                    htmlspecialchars(material.NOME_ARQUIVO) +
                '</p>' +

                '<a href="' + htmlspecialchars(caminhoArquivo) +
                    '" target="_blank">' +
                    'Abrir arquivo' +
                '</a>' +

                '<a href="' + htmlspecialchars(caminhoArquivo) +
                    '" download="' + htmlspecialchars(material.NOME_ARQUIVO) + '">' +
                    'Baixar arquivo' +
                '</a>' +

                '<button type="button" class="adicionar-material-modal" ' +
                    'data-id="' + material.ID_MATERIAL + '">' +
                    'Adicionar à aula' +
                '</button>';


            $('#conteudoMaterial').html(conteudo);

            $('#modalMaterial')[0].showModal();

        })
        .catch(function(erro){

            console.log(erro);

            $('#conteudoMaterial').html(
                "<p>Erro ao carregar o material.</p>"
            );

        });

    });


    $('#fecharMaterial').click(function(){

        $('#modalMaterial')[0].close();

    });


    $('#voltarMaterial').click(function(){

        $('#modalMaterial')[0].close();

    });


    $('#novaAula').click(function(){

        $('#mensagemAula').html('');

        $('#pesquisaMaterial').val('');

        $('#resultadoMateriais').html('');

        $('#materiaisSelecionados').html('');

        $('#modalAula')[0].showModal();

    });


    $('#fecharAula').click(function(){

        $('#modalAula')[0].close();

    });


    function mostrarCalendario(){

        let primeiroDia = new Date(anoAtual, mesAtual, 1);

        let ultimoDia = new Date(anoAtual, mesAtual + 1, 0);

        let diaSemana = primeiroDia.getDay();

        let quantidadeDias = ultimoDia.getDate();


        let nomesMeses = [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ];


        $('#mesAno').html(
            nomesMeses[mesAtual] + " " + anoAtual
        );


        $('#diasCalendario').html('');


        for(let i = 0; i < diaSemana; i++){

            $('#diasCalendario').append(
                '<div class="dia vazio"></div>'
            );

        }


        for(let dia = 1; dia <= quantidadeDias; dia++){

            let classe = "dia";


            if(
                dia == dataAtual.getDate() &&
                mesAtual == dataAtual.getMonth() &&
                anoAtual == dataAtual.getFullYear()
            ){

                classe += " dia-atual";

            }


            let elementoDia = $(
                '<div class="' + classe + '">' +
                    dia +
                '</div>'
            );


            elementoDia.click(function(){

                $('.dia').removeClass('dia-selecionado');

                $(this).addClass('dia-selecionado');

                buscarAulasDia(dia);

            });


            $('#diasCalendario').append(elementoDia);

        }


        buscarPlanejamentos();

    }


    $('#mesAnterior').click(function(){

        mesAtual--;


        if(mesAtual < 0){

            mesAtual = 11;

            anoAtual--;

        }


        mostrarCalendario();

    });


    $('#proximoMes').click(function(){

        mesAtual++;


        if(mesAtual > 11){

            mesAtual = 0;

            anoAtual++;

        }


        mostrarCalendario();

    });


    $('#formAula').submit(function(event){

        event.preventDefault();


        let dados = $(this).serialize();


        fetch("../php/cadPlanejamento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: dados
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();


            if(resposta == "OK!"){

                $('#mensagemAula').html(
                    "Aula cadastrada com sucesso!"
                );


                setTimeout(function(){

                    $('#modalAula')[0].close();

                    $('#formAula')[0].reset();

                    $('#mensagemAula').html('');

                    mostrarCalendario();

                }, 1000);


            } else {

                console.log(resposta);

                $('#mensagemAula').html(
                    "Erro ao cadastrar a aula."
                );

            }

        })
        .catch(function(erro){

            console.log(erro);

            $('#mensagemAula').html(
                "Erro ao cadastrar a aula."
            );

        });

    });


    mostrarCalendario();

});