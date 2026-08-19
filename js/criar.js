$(document).ready(function(){


    // ==========================================
    // MODAL DISCIPLINA
    // ==========================================

    const modalDisciplina = document.getElementById('modalDisciplina');
    const abrirDisciplina = document.getElementById('abrirDisciplina');
    const fecharDisciplina = document.getElementById('fecharDisciplina');


    abrirDisciplina.addEventListener('click', function(){

        modalDisciplina.showModal();

    });


    fecharDisciplina.addEventListener('click', function(){

        modalDisciplina.close();

    });



    // ==========================================
    // MODAL CONTEÚDO
    // ==========================================

    const modalConteudo = document.getElementById('modalConteudo');
    const abrirConteudo = document.getElementById('abrirConteudo');
    const fecharConteudo = document.getElementById('fecharConteudo');


    abrirConteudo.addEventListener('click', function(){

        if($('#id_disciplina').val() == ''){

            alert("Selecione uma disciplina primeiro.");

            return;

        }

        modalConteudo.showModal();

    });


    fecharConteudo.addEventListener('click', function(){

        modalConteudo.close();

    });



    // ==========================================
    // BUSCAR DISCIPLINAS
    // ==========================================

    $('#disciplina').on('input', function(){

        let nome = $(this).val().trim();


        // Se começou a digitar novamente,
        // o ID anterior deixa de ser válido.

        $('#id_disciplina').val('');


        if(nome == ''){

            $('#resultadoDisciplinas').html('');

            return;

        }


        fetch("../php/buscarDisciplinas.php", {

            method: "POST",

            headers: {

                "Content-Type":
                "application/x-www-form-urlencoded"

            },

            body:
                "nome=" +
                encodeURIComponent(nome)

        })

        .then(response => response.text())

        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);

            $('#resultadoDisciplinas').html(resposta);

        })

        .catch(function(erro){

            console.log(erro);

        });

    });



    // ==========================================
    // SELECIONAR DISCIPLINA
    // ==========================================

    $(document).on('click', '.item-disciplina', function(){

        let id = $(this).data('id');

        let nome = $(this).text().trim();


        $('#disciplina').val(nome);

        $('#id_disciplina').val(id);


        $('#resultadoDisciplinas').html('');


        // Ao trocar de disciplina,
        // limpa o conteúdo selecionado.

        $('#conteudo').val('');

        $('#id_conteudo').val('');

        $('#resultadoConteudos').html('');

    });



    // ==========================================
    // BUSCAR CONTEÚDOS
    // ==========================================

    $('#conteudo').on('input', function(){

        let nome = $(this).val().trim();

        let disciplina = $('#id_disciplina').val();


        $('#id_conteudo').val('');


        if(disciplina == ''){

            $('#resultadoConteudos').html('');

            return;

        }


        if(nome == ''){

            $('#resultadoConteudos').html('');

            return;

        }


        fetch("../php/buscarConteudos.php", {

            method: "POST",

            headers: {

                "Content-Type":
                "application/x-www-form-urlencoded"

            },

            body:
                "nome=" +
                encodeURIComponent(nome) +

                "&disciplina=" +
                encodeURIComponent(disciplina)

        })

        .then(response => response.text())

        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);

            $('#resultadoConteudos').html(resposta);

        })

        .catch(function(erro){

            console.log(erro);

        });

    });



    // ==========================================
    // SELECIONAR CONTEÚDO
    // ==========================================

    $(document).on('click', '.item-conteudo', function(){

        let id = $(this).data('id');

        let nome = $(this).text().trim();


        $('#conteudo').val(nome);

        $('#id_conteudo').val(id);


        $('#resultadoConteudos').html('');

    });



    // ==========================================
    // CRIAR DISCIPLINA
    // ==========================================

    $('#formDisciplina').on('submit', function(e){

        e.preventDefault();


        let nome =
            $('#novaDisciplina').val().trim();


        if(nome == ''){

            alert("Digite o nome da disciplina.");

            return;

        }


        fetch("../php/criarDisciplina.php", {

            method: "POST",

            headers: {

                "Content-Type":
                "application/x-www-form-urlencoded"

            },

            body:
                "nome=" +
                encodeURIComponent(nome)

        })

        .then(response => response.text())

        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);


            if(resposta == "OK!"){

                /*
                 * Depois de criar, fazemos uma nova busca
                 * para pegar o ID da disciplina.
                 */

                fetch("../php/buscarDisciplinas.php", {

                    method: "POST",

                    headers: {

                        "Content-Type":
                        "application/x-www-form-urlencoded"

                    },

                    body:
                        "nome=" +
                        encodeURIComponent(nome)

                })

                .then(response => response.text())

                .then(retorno => {

                    $('#resultadoDisciplinas')
                        .html(retorno);


                    /*
                     * Seleciona automaticamente
                     * a disciplina criada.
                     */

                    $('.item-disciplina')
                        .first()
                        .click();

                });


                $('#novaDisciplina').val('');

                modalDisciplina.close();

            }


            else if(resposta == "EXISTE"){

                alert(
                    "Essa disciplina já existe."
                );

            }


            else{

                alert(
                    "Não foi possível criar a disciplina."
                );

            }

        })

        .catch(function(erro){

            console.log(erro);

            alert(
                "Erro ao conectar."
            );

        });

    });



    // ==========================================
    // CRIAR CONTEÚDO
    // ==========================================

    $('#formConteudo').on('submit', function(e){

        e.preventDefault();


        let nome =
            $('#novoConteudo').val().trim();


        let disciplina =
            $('#id_disciplina').val();


        if(nome == ''){

            alert(
                "Digite o nome do conteúdo."
            );

            return;

        }


        if(disciplina == ''){

            alert(
                "Selecione uma disciplina."
            );

            return;

        }


        fetch("../php/criarConteudo.php", {

            method: "POST",

            headers: {

                "Content-Type":
                "application/x-www-form-urlencoded"

            },

            body:
                "nome=" +
                encodeURIComponent(nome) +

                "&disciplina=" +
                encodeURIComponent(disciplina)

        })

        .then(response => response.text())

        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);


            if(resposta == "OK!"){

                /*
                 * Busca o conteúdo recém-criado
                 * para pegar seu ID.
                 */

                fetch("../php/buscarConteudos.php", {

                    method: "POST",

                    headers: {

                        "Content-Type":
                        "application/x-www-form-urlencoded"

                    },

                    body:
                        "nome=" +
                        encodeURIComponent(nome) +

                        "&disciplina=" +
                        encodeURIComponent(disciplina)

                })

                .then(response => response.text())

                .then(retorno => {

                    $('#resultadoConteudos')
                        .html(retorno);


                    /*
                     * Seleciona automaticamente
                     * o conteúdo criado.
                     */

                    $('.item-conteudo')
                        .first()
                        .click();

                });


                $('#novoConteudo').val('');

                modalConteudo.close();

            }


            else if(resposta == "EXISTE"){

                alert(
                    "Esse conteúdo já existe."
                );

            }


            else{

                alert(
                    "Não foi possível criar o conteúdo."
                );

            }

        })

        .catch(function(erro){

            console.log(erro);

            alert(
                "Erro ao conectar."
            );

        });

    });



    // ==========================================
    // VALIDAR FORMULÁRIO PRINCIPAL
    // ==========================================

    $('#criaMaterial').on('submit', function(e){


        if($('#id_disciplina').val() == ''){

            e.preventDefault();

            alert(
                "Selecione uma disciplina."
            );

            return;

        }


        if($('#id_conteudo').val() == ''){

            e.preventDefault();

            alert(
                "Selecione um conteúdo."
            );

            return;

        }


    });

});