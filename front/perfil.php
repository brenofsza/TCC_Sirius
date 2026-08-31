<?php 

session_start(); 

include '../php/conexao.php';


if (!isset($_SESSION['id_usuario'])) {

    header("Location: logar.php");

    exit;

}


$id = $_SESSION['id_usuario'];

$result = mysqli_query(
    $conexao, 
    "SELECT * FROM USUARIO WHERE ID_USU = $id"
);

$row = mysqli_fetch_assoc($result);


if (empty($row['FOTO_USU'])) { 

    $foto = '../img/user.webp'; 

} else { 

    $foto = "../" . $row['FOTO_USU']; 

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Perfil</title>

    <link rel="stylesheet" href="../css/navbar.css">

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


        <li class="active">

            <a href="perfil.php">

                <i class="bx bx-user"></i>

                <span class="tooltip">Perfil</span>

            </a>

        </li>

    </ul>

</nav>


<form id="formFoto" enctype="multipart/form-data">

    <label for="foto" style="cursor: pointer; display: inline-block;">

        <img 
            src="<?php echo $foto; ?>" 
            alt="Foto de perfil" 
            id="imgPerfil" 
            style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;"
        >

        <input 
            type="file" 
            id="foto" 
            name="foto" 
            style="display: none;"
        >

    </label>


    <div 
        id="mensagemF" 
        style="display:none; font-weight:bold; margin:10px 0;"
    ></div>

</form>


<div class="info-perfil">

    <h2>
        <?php echo htmlspecialchars($_SESSION['nome']); ?>
    </h2>


    <p>
        @<?php echo htmlspecialchars($_SESSION['username']); ?>
    </p>


    <?php

    if (!empty($_SESSION['descricao'])) {

        echo nl2br(
            htmlspecialchars($_SESSION['descricao'])
        );

    }

    ?>


    <p id="qtdConexoes">
        0 conexões
    </p>

</div>


<button id="editPerfil">
    Editar Perfil
</button>


<!-- Modal de edição do perfil -->

<dialog id="ModalPerfil">

    <div 
        id="mensagem" 
        style="display:none; font-weight:bold; margin:10px 0;"
    ></div>


    <h2>Editar Perfil</h2>


    <form id="formEditarPerfil">

        <div>

            Nome:

            <input 
                type="text" 
                name="nome" 
                id="nome" 
                value="<?php echo htmlspecialchars($row['NOME_USU']); ?>" 
                required
            >

            <br>

            <i class="bx bxs-user"></i>

        </div>


        <div>

            Username:

            <input 
                type="text" 
                name="username" 
                id="username" 
                value="<?php echo htmlspecialchars($row['USERNAME']); ?>" 
                required
            >

            <br>

            <i class="bx bxs-user"></i>

        </div>


        <div>

            Email:

            <input 
                type="email" 
                name="email" 
                id="email" 
                value="<?php echo htmlspecialchars($row['EMAIL_USU']); ?>" 
                required
            >

            <br>

            <i class="bx bx-envelope"></i>

        </div>


        <div>

            Bio:

            <textarea 
                name="descricao" 
                id="descricao" 
                maxlength="200" 
                placeholder="Conte um pouco sobre você..."
            ><?php echo htmlspecialchars($row['DESCRICAO_USU'] ?? ''); ?></textarea>

        </div>


        <br>


        <button type="submit" id="editInfo">
            Editar
        </button>


        <button type="button" id="fechaEditPer">
            Fechar
        </button>

    </form>


    <button type="button">
        Redefinir Senha
    </button>

</dialog>


<!-- Modal de conexões -->

<dialog id="modalConexoes">

    <button type="button" id="fecharConexoes">

        <i class="bx bx-x"></i>

    </button>


    <h2>Minhas conexões</h2>


    <div id="listaConexoes"></div>

</dialog>


<div class="materiais-perfil">

    <h2>Meus materiais</h2>


    <div class="abas-materiais">

        <button 
            class="abaMaterial ativa" 
            data-tipo="publico"
        >
            Publicos
        </button>


        <button 
            class="abaMaterial" 
            data-tipo="privado"
        >
            Privados
        </button>

    </div>


    <div id="materiaisPublicos"></div>


    <div 
        id="materiaisPrivados" 
        style="display: none;"
    ></div>

</div>


<button>
    Ver materiais salvos
</button>


<a href="../php/logout.php">
    Sair da conta
</a>


<input 
    type="hidden" 
    id="idUsuario" 
    value="<?php echo $id; ?>"
>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="../js/navbar.js"></script>

<script src="../js/editUsu.js"></script>

<script src="../js/fotoUsu.js"></script>

<script src="../js/perfil.js"></script>


</body>

</html>