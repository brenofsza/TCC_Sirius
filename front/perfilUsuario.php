<?php 

session_start(); 

include '../php/conexao.php';


if (!isset($_SESSION['id_usuario'])) {

    header("Location: logar.php");

    exit;

}


$id_usuario = $_GET['id'] ?? '';


if($id_usuario == ''){

    header("Location: pesquisar.php");

    exit;

}


$sql = "SELECT * FROM USUARIO WHERE ID_USU = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    header("Location: pesquisar.php");

    exit;

}


$usuario = $resultado->fetch_assoc();

$stmt->close();


if(empty($usuario['FOTO_USU'])){

    $foto = '../img/user.webp';

} else {

    $foto = '../' . $usuario['FOTO_USU'];

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($usuario['NOME_USU']); ?></title>

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


        <li>

            <a href="perfil.php">

                <i class="bx bx-user"></i>

                <span class="tooltip">Perfil</span>

            </a>

        </li>

    </ul>

</nav>


<main class="perfil-usuario">


<?php

if($id_usuario != $_SESSION['id_usuario']){

?>

    <button id="ligarUsuario">Conectar</button>

<?php 

}

?>


    <a href="javascript:history.back()" class="voltar">

        <i class="bx bx-arrow-back"></i>

        Voltar

    </a>


    <div class="info-perfil">

        <img 
            src="<?php echo htmlspecialchars($foto); ?>" 
            alt="Foto de perfil"
        >

        <h2>
            <?php echo htmlspecialchars($usuario['NOME_USU']); ?>
        </h2>

        <p>
            @<?php echo htmlspecialchars($usuario['USERNAME']); ?>
        </p>

        <p id="qtdConexoes">
            0 conexões
        </p>


        <?php

        if(!empty($usuario['DESCRICAO_USU'])){

            echo "<p>" . 
                 nl2br(htmlspecialchars($usuario['DESCRICAO_USU'])) . 
                 "</p>";

        }

        ?>

    </div>


    <!-- Modal de conexões -->

    <dialog id="modalConexoes">

        <button type="button" id="fecharConexoes">

            <i class="bx bx-x"></i>

        </button>


        <h2>Conexões</h2>


        <div id="listaConexoes"></div>

    </dialog>


    <input 
        type="hidden" 
        id="idUsuario" 
        value="<?php echo $id_usuario; ?>"
    >


    <div class="materiais-perfil">

        <h2>Materiais</h2>

        <div id="materiaisPublicos"></div>

    </div>


</main>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="../js/navbar.js"></script>

<script src="../js/pfUsu.js"></script>


</body>

</html>