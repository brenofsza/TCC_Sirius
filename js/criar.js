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
            alert("Selecione uma disciplina primeiro.");
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
            alert("Digite o nome da disciplina.");
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

            } else if (resposta == "EXISTE") {

                alert("Essa disciplina já existe.");

            } else {

                alert("Não foi possível criar a disciplina.");
            }
        })
        .catch(function(erro) {

            console.log(erro);
            alert("Erro ao conectar.");
        });
    });

    // cria um novo cont
    $('#formCont').on('submit', function(e) {

        e.preventDefault();

        let nome = $('#novoCont').val().trim();
        let disci = $('#id_disci').val();

        if (nome == '') {
            alert("Digite o nome do conteúdo.");
            return;
        }

        if (disci == '') {
            alert("Selecione uma disciplina.");
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

            } else if (resposta == "EXISTE") {

                alert("Esse conteúdo já existe.");

            } else {

                alert("Não foi possível criar o conteúdo.");
            }
        })
        .catch(function(erro) {

            console.log(erro);
            alert("Erro ao conectar.");
        });
    });

    // cadastra o material
    $('#criaMaterial').on('submit', function(e) {

        e.preventDefault();

        if ($('#titulo').val().trim() == '') {
            alert("Digite o título do material.");
            return;
        }

        if ($('#id_disci').val() == '') {
            alert("Selecione uma disciplina.");
            return;
        }

        if ($('#id_cont').val() == '') {
            alert("Selecione um conteúdo.");
            return;
        }

        if ($('#nivel').val() == '') {
            alert("Selecione o nível de ensino.");
            return;
        }

        if (!$('input[name="status"]:checked').val()) {
            alert("Selecione o status do material.");
            return;
        }

        if ($('#arquivo')[0].files.length == 0) {
            alert("Selecione um arquivo.");
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

                alert("Material cadastrado com sucesso!");

                $('#criaMaterial')[0].reset();
                $('#id_disci').val('');
                $('#id_cont').val('');

            } else if (resposta == "campos_vazios") {

                alert("Preencha todos os campos.");

            } else if (resposta == "erro_arquivo") {

                alert("Selecione um arquivo válido.");

            } else if (resposta == "erro_tamanho") {

                alert("O arquivo deve ter no máximo 10 MB.");

            } else if (resposta == "erro_extensao") {

                alert("Esse tipo de arquivo não é permitido.");

            } else if (resposta == "erro_upload") {

                alert("Não foi possível enviar o arquivo.");

            } else if (resposta == "erro_banco") {

                alert("Não foi possível cadastrar o material.");

            } else {

                alert("Ocorreu um erro ao cadastrar o material.");
            }
        })
        .catch(function(erro) {

            console.log(erro);
            alert("Erro ao conectar.");
        });
    });

});