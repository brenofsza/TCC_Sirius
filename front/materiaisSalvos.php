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
    <title>Materiais salvos</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>


<nav class="sidebar-navigation">

    <ul>

        <li>

            <a href="../index.php">

                <i class="bx bx-home-alt"></i>

                <span class="tooltip">Inicio</span>

            </a>

        </li>


        <li>

            <a href="criar.php">

                <i class="bx bx-plus"></i>

                <span class="tooltip">Criar</span>

            </a>

        </li>


        <li>

            <a href="pesquisar.php">

                <i class="bx bx-search-alt"></i>

                <span class="tooltip">Pesquisar</span>

            </a>

        </li>


        <li>

            <a href="planejamento.php">

                <i class="bx bx-calendar-event"></i>

                <span class="tooltip">Planejamento</span>

            </a>

        </li>


        <li>

            <a href="perfil.php">

                <i class="bx bx-user"></i>

                <span class="tooltip">Perfil</span>

            </a>

        </li>

    </ul>

</nav>


<main class="materiais-salvos">

    <h1>Materiais salvos</h1>


    <button type="button" id="novaPasta">

        <i class="bx bx-plus"></i>

        Nova pasta

    </button>


    <div id="listaPastas"></div>

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