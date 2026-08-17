$(document).ready(function(){

    $('#foto').change(function(e){
        e.preventDefault();

        if($('#foto').val() == ''){
            return;
        }

        let formElement = document.getElementById('formFoto'); 
        let formData = new FormData(formElement);
        
        fetch("../php/fotoUsuario.php", { 
            method: "POST",
            body: formData 
        })
        .then(response => response.text())
        .then(retorno => {
            console.log(retorno);

            let resposta = retorno.trim();

            if(resposta == "erro_arquivo" || resposta == "erro_upload"){
                $('#mensagemF').html("Erro ao processar o arquivo no servidor.").css("color", "red");
            
            } else if(resposta == "erro_tamanho"){
                $('#mensagemF').html("A imagem deve ter no máximo 2MB.").css("color", "red");
            
            } else if(resposta == "erro_extensao"){
                $('#mensagemF').html("Formato inválido! Use JPG, PNG ou WEBP.").css("color", "red");
            
            } else if(resposta == "erro_banco"){
                $('#mensagemF').html("Erro ao salvar o caminho no banco de dados.").css("color", "red");
            
            } else if(resposta.startsWith("uploads/")){ 
                $('#imgPerfil').attr('src', '../' + resposta);
                $('#mensagemF').html("Foto atualizada com sucesso!").css("color", "green");
            
            } else {
                $('#mensagemF').html("Ocorreu um erro desconhecido.").css("color", "red");
            }

            $('#mensagemF').fadeIn(300).delay(2000).fadeOut(400);
            $('#foto').val('');

        })
        .catch(function(erro){
            console.log(erro);
            $('#mensagemF').html("Erro ao conectar com o servidor.").css("color", "red");
            $('#mensagemF').fadeIn(300).delay(2000).fadeOut(400);
            $('#foto').val('');
        });
    });

});
