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

                console.log(
                    "Dia selecionado: " +
                    dia + "/" +
                    (mesAtual + 1) + "/" +
                    anoAtual
                );

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


    $('#novaAula').click(function(){

        $('#mensagemAula').html('');

        $('#modalAula')[0].showModal();

    });


    $('#fecharAula').click(function(){

        $('#modalAula')[0].close();

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