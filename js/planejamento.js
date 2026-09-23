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

            $('.dia').removeClass('tem-aula');

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

                let materiais = '';

                if(aula.MATERIAIS && aula.MATERIAIS.length > 0){

                    materiais +=
                        '<div class="materiais-aula">' +
                            '<strong>Materiais:</strong>';

                    aula.MATERIAIS.forEach(function(material){

                        materiais +=
                            '<p>' +
                                '<a href="material.php?id=' + material.ID_MATERIAL + '">' +
                                    htmlspecialchars(material.TITULO_MATERIA) +
                                '</a>' +
                            '</p>';

                    });

                    materiais +=
                        '</div>';

                }


                $('#listaAulasDia').append(

                    '<div class="aula">' +

                        '<div class="acoes-aula">' +

                            '<button type="button" class="editar-aula" data-id="' +
                                aula.ID_PLANEJAMENTO + '">' +

                                '<i class="bx bx-edit"></i>' +

                            '</button>' +

                            '<button type="button" class="excluir-aula" data-id="' +
                                aula.ID_PLANEJAMENTO + '">' +

                                '<i class="bx bx-trash"></i>' +

                            '</button>' +

                        '</div>' +

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

                        materiais +

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

    $('#pesquisaMaterialEditar').on('input', function(){

        let pesquisa = $(this).val().trim();


        if(pesquisa == ''){

            $('#resultadoMateriaisEditar').html('');

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

            $('#resultadoMateriaisEditar').html('');


            if(materiais.length == 0){

                $('#resultadoMateriaisEditar').html(
                    "<p>Nenhum material encontrado.</p>"
                );

                return;

            }


            materiais.forEach(function(material){

                $('#resultadoMateriaisEditar').append(

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

                            '<button type="button" class="ver-material-editar" ' +
                                'data-id="' + material.ID_MATERIAL + '">' +
                                'Ver material' +
                            '</button>' +

                            '<button type="button" class="adicionar-material-editar" ' +
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

            $('#resultadoMateriaisEditar').html(
                "<p>Erro ao buscar materiais.</p>"
            );

        });

    });

$(document).on('click', '.adicionar-material-editar', function(){

    let idMaterial = $(this).data('id');

    let titulo = $(this).closest('.resultado-material').find('h3').text();


    if($('#materiaisSelecionadosEditar .material-selecionado[data-id="' + idMaterial + '"]').length > 0){

        return;

    }


    $('#materiaisSelecionadosEditar').append(

        '<div class="material-selecionado" data-id="' + idMaterial + '">' +

            '<span>' +
                htmlspecialchars(titulo) +
            '</span>' +

            '<button type="button" class="remover-material">' +
                'Remover' +
            '</button>' +

        '</div>'

    );

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

                '<a href="' + htmlspecialchars(caminhoArquivo) +
                    '" target="_blank">' +
                    'Abrir arquivo' +
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

$(document).on('click', '.ver-material-editar', function(){

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

            '<a href="' + htmlspecialchars(caminhoArquivo) +
                '" target="_blank">' +
                'Abrir arquivo' +
            '</a>' +

            '<button type="button" class="adicionar-material-modal-editar" ' +
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


    $(document).on('click', '.adicionar-material, .adicionar-material-modal', function(){

        let idMaterial = $(this).data('id');

        let titulo = '';


        if($(this).hasClass('adicionar-material-modal')){

            titulo = $('#conteudoMaterial h2').text();

        } else {

            titulo = $(this).closest('.resultado-material').find('h3').text();

        }


        if($('.material-selecionado[data-id="' + idMaterial + '"]').length > 0){

            $('#modalMaterial')[0].close();

            return;

        }


        $('#materiaisSelecionados').append(

            '<div class="material-selecionado" data-id="' + idMaterial + '">' +

                '<span>' +
                    htmlspecialchars(titulo) +
                '</span>' +

                '<button type="button" class="remover-material">' +
                    'Remover' +
                '</button>' +

            '</div>'

        );


        $('#modalMaterial')[0].close();

    });


    $(document).on('click', '.remover-material', function(){

        $(this).closest('.material-selecionado').remove();

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
                '<div class="' + classe + '" data-dia="' + dia + '">' +
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

        let materiais = [];


        $('#materiaisSelecionados .material-selecionado').each(function(){

            materiais.push($(this).data('id'));

        });


        dados += "&materiais=" + encodeURIComponent(materiais.join(","));


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


    let idAulaEditar = null;


    $(document).on('click', '.editar-aula', function(){

        idAulaEditar = $(this).data('id');


        fetch("../php/edtPlanejamento.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_planejamento=" + encodeURIComponent(idAulaEditar)
        })
        .then(response => response.json())
        .then(aula => {

            if(!aula.ID_PLANEJAMENTO){

                $('#mensagemEditarAula').html(
                    "Erro ao carregar a aula."
                );

                return;

            }


            $('#tituloEditarAula').val(aula.TITULO_PLAN);

            $('#assuntoEditarAula').val(aula.ASSUNTO);

            $('#dataEditarAula').val(aula.DATA_AULA);

            $('#horaInicioEditarAula').val(
                aula.HORA_INICIO.substring(0, 5)
            );

            $('#horaFimEditarAula').val(
                aula.HORA_FIM.substring(0, 5)
            );

            $('#salaEditarAula').val(aula.SALA);


            $('#pesquisaMaterialEditar').val('');

            $('#resultadoMateriaisEditar').html('');

            $('#materiaisSelecionadosEditar').html('');


            if(aula.MATERIAIS && aula.MATERIAIS.length > 0){

                aula.MATERIAIS.forEach(function(material){

                    $('#materiaisSelecionadosEditar').append(

                        '<div class="material-selecionado" data-id="' +
                            material.ID_MATERIAL + '">' +

                            '<span>' +
                                htmlspecialchars(material.TITULO_MATERIA) +
                            '</span>' +

                            '<button type="button" class="remover-material">' +
                                'Remover' +
                            '</button>' +

                        '</div>'

                    );

                });

            }


            $('#mensagemEditarAula').html('');

            $('#modalEditarAula')[0].showModal();

        })
        .catch(function(erro){

            console.log(erro);

            $('#mensagemEditarAula').html(
                "Erro ao carregar a aula."
            );

        });

    });


    $('#fecharEditarAula').click(function(){

        $('#modalEditarAula')[0].close();

        idAulaEditar = null;

    });

$('#formEditarAula').submit(function(event){

    event.preventDefault();

    if(idAulaEditar == null){

        return;

    }

        let dados = $(this).serialize();


        let materiais = [];

        $('#materiaisSelecionadosEditar .material-selecionado').each(function(){

            materiais.push($(this).data('id'));

        });


        dados += "&materiais=" + encodeURIComponent(materiais.join(","));
        dados += "&id_planejamento=" + encodeURIComponent(idAulaEditar);
        dados += "&acao=salvar";


    let diaSelecionado = $('.dia-selecionado').data('dia');


    fetch("../php/edtPlanejamento.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: dados
    })
    .then(response => response.json())
    .then(retorno => {

        if(retorno.resposta == "OK!"){

            $('#modalEditarAula')[0].close();

            idAulaEditar = null;

            mostrarCalendario();


            if(diaSelecionado){

                let diaElemento = $('.dia[data-dia="' + diaSelecionado + '"]');

                diaElemento.addClass('dia-selecionado');

                buscarAulasDia(diaSelecionado);

            }

        } else {

            $('#mensagemEditarAula').html(
                "Erro ao salvar as alterações."
            );

            console.log(retorno);

        }

    })
    .catch(function(erro){

        console.log(erro);

        $('#mensagemEditarAula').html(
            "Erro ao salvar as alterações."
        );

    });

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


        let diaSelecionado = $('.dia-selecionado').data('dia');


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


                if(diaSelecionado){

                    let diaElemento = $('.dia[data-dia="' + diaSelecionado + '"]');


                    diaElemento.addClass('dia-selecionado');


                    buscarAulasDia(diaSelecionado);

                }

            } else {

                console.log(resposta);

            }

        })
        .catch(function(erro){

            console.log(erro);

        });

    });


    mostrarCalendario();

});