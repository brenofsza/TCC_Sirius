$(document).ready(function(){

    $('#botaoLogar').click(function(e){
        e.preventDefault();

        if($('#email').val().trim() == '' || $('#senha').val().trim() == ''){
            $('#mensagem').html("Preencha todos os campos!").css("color", "red");
            $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
            return;
        } 

        let email = $('#email').val();
        let senha = $('#senha').val();
        
        fetch("../php/verificar.php", {
            method: "POST",
            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },
            body: "email=" + encodeURIComponent(email) + 
                  "&senha=" + encodeURIComponent(senha)
        })
        .then(response => response.text())
        .then(retorno => {
            console.log(retorno);

            if(retorno.trim() == "ok"){
                window.location.href = "../index.php";
            } else {
                $('#mensagem').html("Email/Usuário ou senha inválidos").css("color", "red");
                $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
            }

        })
        .catch(function(erro){
            console.log(erro);
            $('#mensagem').html("Erro ao conectar").css("color", "red");
            $('#mensagem').fadeIn(300).delay(2000).fadeOut(400);
        });
    });

});
