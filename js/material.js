$(document).ready(function(){

    function verificarMaterialSalvo(){

        let idMaterial = $('#salvarMaterial').data('id');


        fetch("../php/verMatSalvo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_material=" + encodeURIComponent(idMaterial)
        })
        .then(response => response.text())
        .then(retorno => {

            let resposta = retorno.trim();


            if(resposta == "SIM"){

                $('#salvarMaterial').html(
                    '<i class="bx bx-bookmark"></i> Salvo'
                );

            } else {

                $('#salvarMaterial').html(
                    '<i class="bx bx-bookmark"></i> Salvar material'
                );

            }

        })
        .catch(function(erro){

            console.log(erro);

        });

    }


    $('#salvarMaterial').click(function(){

        $('#modalSalvarMaterial')[0].showModal();

        $('#pastasSalvar').html("<p>Carregando pastas...</p>");


        fetch("../php/buscarPastasModal.php", {
            method: "POST"
        })
        .then(response => response.text())
        .then(retorno => {

            $('#pastasSalvar').html(retorno);

        })
        .catch(function(erro){

            console.log(erro);

            $('#pastasSalvar').html(
                "<p>Erro ao carregar as pastas.</p>"
            );

        });

    });


    $('#fecharSalvarMaterial').click(function(){

        $('#modalSalvarMaterial')[0].close();

    });


    $(document).on('click', '.pastaSalvar', function(){

        let idPasta = $(this).data('id');

        let idMaterial = $('#salvarMaterial').data('id');


        fetch("../php/salvarMaterial.php", {
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

                $('#salvarMaterial').html(
                    '<i class="bx bx-bookmark"></i> Salvo'
                );

                $('#pastasSalvar').html(
                    "<p>Material salvo com sucesso!</p>"
                );


                setTimeout(function(){

                    $('#modalSalvarMaterial')[0].close();

                }, 1000);


            } else if(resposta == "JA_SALVO"){

                $('#pastasSalvar').html(
                    "<p>O material já está salvo nesta pasta.</p>"
                );


            } else {

                console.log(resposta);

                $('#pastasSalvar').html(
                    "<p>Erro ao salvar o material.</p>"
                );

            }

        })
        .catch(function(erro){

            console.log(erro);

            $('#pastasSalvar').html(
                "<p>Erro ao salvar o material.</p>"
            );

        });

    });


    verificarMaterialSalvo();

});