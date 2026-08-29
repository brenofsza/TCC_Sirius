<?php 
session_start(); 
include '../php/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: logar.php");
    exit;
}

$id_material = $_GET['id'] ?? '';

if($id_material == ''){
    header("Location: pesquisar.php");
    exit;
}


$sql = "SELECT MATERIAL.*, CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI,
            NIVEL_ENSINO.NOME_NIVEL, USUARIO.NOME_USU, USUARIO.USERNAME, USUARIO.FOTO_USU
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        INNER JOIN NIVEL_ENSINO ON MATERIAL.COD_NIVEL = NIVEL_ENSINO.ID_NIVEL
        INNER JOIN USUARIO ON MATERIAL.COD_USU = USUARIO.ID_USU
        WHERE MATERIAL.ID_MATERIAL = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_material);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){
    header("Location: pesquisar.php");
    exit;
}


$material = $resultado->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($material['TITULO_MATERIA']); ?></title>

    <link rel="icon" type="image/png" href="../img/preBancaTCC.jpg">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/material.css">
</head>

<body>

    <div class="topbar">

        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>

        <div class="user">
            <?php

            if(empty($_SESSION['foto_usuario'])){

                $foto = '../img/user.webp';

            } else {

                $foto = '../' . $_SESSION['foto_usuario'];

            }

            echo "<p>Olá, " . htmlspecialchars($_SESSION['nome']) . "!</p>";
            echo "<a href='perfil.php'><img src='$foto' class='fotoPerfil'></a>";

            ?>
        </div>

    </div>


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


    <main class="area-material">

        <a href="javascript:history.back()" class="voltar">
            <i class="bx bx-arrow-back"></i>
            Voltar
        </a>


        <div class="material">

            <h1>
                <?php echo htmlspecialchars($material['TITULO_MATERIA']); ?>
            </h1>


            <p>
                <strong>Disciplina:</strong>
                <?php echo htmlspecialchars($material['NOME_DISCI']); ?>
            </p>


            <p>
                <strong>Conteúdo:</strong>
                <?php echo htmlspecialchars($material['NOME_CONTEUDO']); ?>
            </p>


            <p>
                <strong>Nível:</strong>
                <?php echo htmlspecialchars($material['NOME_NIVEL']); ?>
            </p>


            <?php if(!empty($material['DESCRICAO_MATERIA'])){ ?>

                <p>
                    <strong>Descrição:</strong>
                    <?php echo htmlspecialchars($material['DESCRICAO_MATERIA']); ?>
                </p>

            <?php } ?>


           <div class="autor-material">

            <?php

            if(empty($material['FOTO_USU'])){

                $fotoAutor = '../img/user.webp';

            } else {

                $fotoAutor = '../' . $material['FOTO_USU'];

            }

            ?>

            <img src="<?php echo htmlspecialchars($fotoAutor); ?>" class="fotoPerfil">

            <div>
                <p>
                    Publicado por:
                </p>

                <p>
                    <?php echo htmlspecialchars($material['NOME_USU']); ?>
                    (@<?php echo htmlspecialchars($material['USERNAME']); ?>)
                </p>
            </div>

        </div>


            <p>
                <strong>Data:</strong>
                <?php echo date("d/m/Y", strtotime($material['DATA_CAD'])); ?>
            </p>


            <p>
                <strong>Arquivo:</strong>
                <?php echo htmlspecialchars($material['NOME_ARQUIVO']); ?>
            </p>


            <a href="../<?php echo htmlspecialchars($material['CAMINHO_ARQUIVO']); ?>" target="_blank">
                Abrir arquivo
            </a>

        </div>

    </main>


</body>

</html>