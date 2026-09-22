<?php

session_start();

if(!isset($_SESSION['id_usuario'])){

    header("Location: logar.php");

    exit;

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/materiaisSalvos.css">
    <title>Materiais salvos</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>


<main class="materiais-salvos">

    <!-- Alinha a apresentação da página e a ação de criar pasta. -->
    <div class="cabecalho-salvos">
        <!-- Reúne o caminho de volta, o título e a descrição. -->
        <div>
            <a class="voltar-perfil" href="perfil.php"><i class="bx bx-arrow-back" aria-hidden="true"></i> Voltar ao perfil</a>
            <h1>Materiais salvos</h1>
            <p>Organize os materiais que você guardou em pastas.</p>
        </div>
        <button type="button" id="novaPasta"><i class="bx bx-plus" aria-hidden="true"></i> Nova pasta</button>
    </div>


    <!-- O JavaScript carrega aqui os cartões das pastas ou a mensagem de lista vazia. -->
    <div id="listaPastas"></div>

    <!-- Explica o fluxo de organização, mesmo antes de o usuário criar pastas. -->
    <section class="guia-salvos" aria-labelledby="tituloGuiaSalvos">
        <!-- Apresenta o objetivo da área de materiais salvos. -->
        <div class="guia-salvos-cabecalho">
            <span>ORGANIZE SEUS CONTEÚDOS</span>
            <h2 id="tituloGuiaSalvos">Sua biblioteca, do seu jeito</h2>
            <p>Separe os materiais por tema, turma ou disciplina para encontrá-los quando precisar.</p>
        </div>
        <!-- As três linhas abaixo mostram a sequência de uso da biblioteca. -->
        <div class="guia-salvos-passos">
            <!-- Primeiro passo: criar a pasta. -->
            <div><span>01</span><p>Crie uma pasta para reunir materiais relacionados.</p></div>
            <!-- Segundo passo: salvar um material nela. -->
            <div><span>02</span><p>Abra um material e salve-o na pasta desejada.</p></div>
            <!-- Terceiro passo: consultar os materiais organizados. -->
            <div><span>03</span><p>Volte aqui para consultar o que você organizou.</p></div>
        </div>
    </section>

</main>

<dialog id="modalNovaPasta">
     <div class="modal-nova-pasta"> 
        <button type="button" id="fecharNovaPasta"> 
            <i class="bx bx-x"></i> 
        </button> 
    
    <h2>Nova pasta</h2> 
    
    <input type="text" id="nomePasta" placeholder="Nome da pasta" maxlength="50" > 
        <button type="button" id="criarPasta"> Criar pasta </button> 
        
        <p id="mensagemPasta"></p> 
     </div> 
</dialog>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/materiaisSalvos.js"></script>


</body>

</html>
