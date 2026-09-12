$(document).ready(function(){

    $('#renomearPasta').click(function(){

        $('#modalRenomearPasta')[0].showModal();

    });


    $('#fecharRenomearPasta').click(function(){

        $('#modalRenomearPasta')[0].close();

    });


    $('#salvarNomePasta').click(function(){

        let novoNome = $('#novoNomePasta').val().trim();

        let idPasta = new URLSearchParams(window.location.search).get('id');


        if(novoNome == ''){

            $('#mensagemRenomear').html(
                "Digite um nome para a pasta."
            );

            return;

        }


        fetch("../php/edtPasta.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_pasta=" + encodeURIComponent(idPasta) +
                  "&nome_pasta=" + encodeURIComponent(novoNome)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();


            if(resposta == "OK!"){

                $('#mensagemRenomear').html(
                    "Pasta renomeada com sucesso!"
                );


                setTimeout(function(){

                    location.reload();

                }, 1000);


            } else if(resposta == "EXISTE"){

                $('#mensagemRenomear').html(
                    "Você já possui uma pasta com esse nome."
                );


            } else if(resposta == "NOME_VAZIO"){

                $('#mensagemRenomear').html(
                    "Digite um nome para a pasta."
                );


            } else {

                console.log(resposta);

                $('#mensagemRenomear').html(
                    "Erro ao renomear a pasta."
                );

            }

        })
        .catch(function(erro){

            console.log(erro);

            $('#mensagemRenomear').html(
                "Erro ao renomear a pasta."
            );

        });

    });


    $('#excluirPasta').click(function(){

        $('#mensagemExcluir').html('');

        $('#modalExcluirPasta')[0].showModal();

    });


    $('#fecharExcluirPasta').click(function(){

        $('#modalExcluirPasta')[0].close();

    });


    $('#cancelarExcluirPasta').click(function(){

        $('#modalExcluirPasta')[0].close();

    });


    $('#confirmarExcluirPasta').click(function(){

        let idPasta = new URLSearchParams(window.location.search).get('id');


        fetch("../php/excPasta.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_pasta=" + encodeURIComponent(idPasta)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();


            if(resposta == "OK!"){

                $('#mensagemExcluir').html(
                    "Pasta excluída com sucesso!"
                );


                setTimeout(function(){

                    window.location.href = "materiaisSalvos.php";

                }, 1000);


            } else {

                console.log(resposta);

                $('#mensagemExcluir').html(
                    "Erro ao excluir a pasta."
                );

            }

        })
        .catch(function(erro){

            console.log(erro);

            $('#mensagemExcluir').html(
                "Erro ao excluir a pasta."
            );

        });

    });


    $(document).on('click', '.removerMaterial', function(event){

        event.preventDefault();

        event.stopPropagation();


        $('#mensagemRemover').html('');


        $('#modalRemoverMaterial').data(
            'id-material',
            $(this).data('id')
        );


        $('#modalRemoverMaterial')[0].showModal();

    });


    $('#fecharRemoverMaterial').click(function(){

        $('#modalRemoverMaterial')[0].close();

    });


    $('#cancelarRemoverMaterial').click(function(){

        $('#modalRemoverMaterial')[0].close();

    });


    $('#confirmarRemoverMaterial').click(function(){

        let idMaterial = $('#modalRemoverMaterial').data('id-material');

        let idPasta = new URLSearchParams(window.location.search).get('id');


        fetch("../php/excMaterialPasta.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_material=" + encodeURIComponent(idMaterial) +
                  "&id_pasta=" + encodeURIComponent(idPasta)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();


            if(resposta == "OK!"){

                $('#mensagemRemover').html(
                    "Material removido da pasta!"
                );


                setTimeout(function(){

                    location.reload();

                }, 1000);


            } else {

                console.log(resposta);

                $('#mensagemRemover').html(
                    "Erro ao remover o material."
                );

            }

        })
        .catch(function(erro){

            console.log(erro);

            $('#mensagemRemover').html(
                "Erro ao remover o material."
            );

        });

    });

});