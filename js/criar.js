$(document).ready(function() {

    const modalDisciplina = document.getElementById('modalDisci');
    const abrirDisciplina = document.getElementById('abrirDisci');
    const fecharDisciplina = document.getElementById('fecharDisci');

    // abre modal disci
    abrirDisciplina.addEventListener('click', function() {
        modalDisciplina.showModal();
    });

    // fecha o modal disci
    fecharDisciplina.addEventListener('click', function() {
        modalDisciplina.close();
    });

    const modalConteudo = document.getElementById('modalCont');
    const abrirConteudo = document.getElementById('abrirCont');
    const fecharConteudo = document.getElementById('fecharCont');

    // abre o modal cont
    abrirConteudo.addEventListener('click', function() {
        if ($('#id_disci').val() == '') {
            $('#mensagem').html("Selecione uma disciplina primeiro.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        modalConteudo.showModal();
    });

    // fecha o modal cont
    fecharConteudo.addEventListener('click', function() {
        modalConteudo.close();
    });

    // typeahead da disciplina
    $('#disci').typeahead({
        source: function(query, process) {

            fetch("../php/buscarDisci.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "nome=" + encodeURIComponent(query)
            })
            .then(response => response.json())
            .then(dados => {

                process(dados.map(function(disci) {
                    return disci.nome;
                }));

                $('#disci').data('disciplinas', dados);
            })
            .catch(function(erro) {
                console.log(erro);
            });
        },

        minLength: 1,
        items: 8,

        updater: function(nome) {

            let disciplinas = $('#disci').data('disciplinas') || [];

            let disciplina = disciplinas.find(function(disci) {
                return disci.nome == nome;
            });

            if (disciplina) {

                $('#id_disci').val(disciplina.id);

                $('#cont').val('');
                $('#id_cont').val('');
            }

            return nome;
        }
    });

    // limpa o ID qnd alterar a disciplina
    $('#disci').on('input', function() {

        $('#id_disci').val('');

        $('#cont').val('');
        $('#id_cont').val('');
    });

    // typeahead do conteúdo
    $('#cont').typeahead({
        source: function(query, process) {

            let disci = $('#id_disci').val();

            if (disci == '') {
                return;
            }

            fetch("../php/buscarCont.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "nome=" + encodeURIComponent(query) +
                    "&disci=" + encodeURIComponent(disci)
            })
            .then(response => response.json())
            .then(dados => {

                process(dados.map(function(cont) {
                    return cont.nome;
                }));

                $('#cont').data('conteudos', dados);
            })
            .catch(function(erro) {
                console.log(erro);
            });
        },

        minLength: 1,
        items: 8,

        updater: function(nome) {

            let conteudos = $('#cont').data('conteudos') || [];

            let conteudo = conteudos.find(function(cont) {
                return cont.nome == nome;
            });

            if (conteudo) {
                $('#id_cont').val(conteudo.id);
            }

            return nome;
        }
    });

    // limpa o ID qnd alterar o conteúdo
    $('#cont').on('input', function() {

        $('#id_cont').val('');
    });

    // cria uma nova disci
    $('#formDisci').on('submit', function(e) {

        e.preventDefault();

        let nome = $('#novaDisci').val().trim();

        if (nome == '') {
            $('#mensagem').html("Digite o nome da disciplina.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        fetch("../php/criarDisci.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "nome=" + encodeURIComponent(nome)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);

            if (resposta == "OK!") {

                fetch("../php/buscarDisci.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "nome=" + encodeURIComponent(nome)
                })
                .then(response => response.json())
                .then(dados => {

                    let disciplina = dados.find(function(disci) {
                        return disci.nome == nome;
                    });

                    if (disciplina) {
                        $('#disci').val(disciplina.nome);
                        $('#id_disci').val(disciplina.id);
                    }
                });

                $('#novaDisci').val('');
                modalDisciplina.close();

                $('#mensagem').html("Disciplina criada com sucesso!").css("color", "green").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "EXISTE") {

                $('#mensagem').html("Essa disciplina já existe.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else {

                $('#mensagem').html("Não foi possível criar a disciplina.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            }
        })
        .catch(function(erro) {

            console.log(erro);
            $('#mensagem').html("Erro ao conectar.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
        });
    });

    // cria um novo cont
    $('#formCont').on('submit', function(e) {

        e.preventDefault();

        let nome = $('#novoCont').val().trim();
        let disci = $('#id_disci').val();

        if (nome == '') {
            $('#mensagem').html("Digite o nome do conteúdo.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        if (disci == '') {
            $('#mensagem').html("Selecione uma disciplina.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        fetch("../php/criarCont.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "nome=" + encodeURIComponent(nome) +
                "&disci=" + encodeURIComponent(disci)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);

            if (resposta == "OK!") {

                fetch("../php/buscarCont.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "nome=" + encodeURIComponent(nome) +
                        "&disci=" + encodeURIComponent(disci)
                })
                .then(response => response.json())
                .then(dados => {

                    let conteudo = dados.find(function(cont) {
                        return cont.nome == nome;
                    });

                    if (conteudo) {
                        $('#cont').val(conteudo.nome);
                        $('#id_cont').val(conteudo.id);
                    }
                });

                $('#novoCont').val('');
                modalConteudo.close();

                $('#mensagem').html("Conteúdo criado com sucesso!").css("color", "green").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "EXISTE") {

                $('#mensagem').html("Esse conteúdo já existe.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else {

                $('#mensagem').html("Não foi possível criar o conteúdo.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            }
        })
        .catch(function(erro) {

            console.log(erro);
            $('#mensagem').html("Erro ao conectar.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
        });
    });

    // cadastra o material
    $('#criaMaterial').on('submit', function(e) {

        e.preventDefault();

        if ($('#titulo').val().trim() == '') {
            $('#mensagem').html("Digite o título do material.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        if ($('#id_disci').val() == '') {
            $('#mensagem').html("Selecione uma disciplina.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        if ($('#id_cont').val() == '') {
            $('#mensagem').html("Selecione um conteúdo.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        if ($('#nivel').val() == '') {
            $('#mensagem').html("Selecione o nível de ensino.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        if (!$('input[name="status"]:checked').val()) {
            $('#mensagem').html("Selecione o status do material.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        if ($('#arquivo')[0].files.length == 0) {
            $('#mensagem').html("Selecione um arquivo.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            return;
        }

        let formData = new FormData(this);

        fetch("../php/cadMaterial.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();

            console.log(resposta);

            if (resposta == "OK!") {

                $('#mensagem').html("Material cadastrado com sucesso!").css("color", "green").fadeIn(300).delay(2000).fadeOut(400);

                $('#criaMaterial')[0].reset();
                $('#id_disci').val('');
                $('#id_cont').val('');

            } else if (resposta == "campos_vazios") {

                $('#mensagem').html("Preencha todos os campos.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "erro_arquivo") {

                $('#mensagem').html("Selecione um arquivo válido.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "erro_tamanho") {

                $('#mensagem').html("O arquivo deve ter no máximo 10 MB.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "erro_extensao") {

                $('#mensagem').html("Esse tipo de arquivo não é permitido.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "erro_upload") {

                $('#mensagem').html("Não foi possível enviar o arquivo.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else if (resposta == "erro_banco") {

                $('#mensagem').html("Não foi possível cadastrar o material.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);

            } else {

                $('#mensagem').html("Ocorreu um erro ao cadastrar o material.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
            }
        })
        .catch(function(erro) {

            console.log(erro);
            $('#mensagem').html("Erro ao conectar.").css("color", "red").fadeIn(300).delay(2000).fadeOut(400);
        });
    });

});