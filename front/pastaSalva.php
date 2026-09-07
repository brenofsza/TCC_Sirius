<?php

session_start();

include '../php/conexao.php';


if(!isset($_SESSION['id_usuario'])){

    header("Location: logar.php");

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_pasta = $_GET['id'] ?? '';


if($id_pasta == ''){

    header("Location: materiaisSalvos.php");

    exit;

}


// busca a pasta do usuário logado

$sql = "SELECT *
        FROM PASTA
        WHERE ID_PASTA = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_pasta, $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    header("Location: materiaisSalvos.php");

    exit;

}


$pasta = $resultado->fetch_assoc();

$stmt->close();


// busca os materiais salvos nesta pasta

$sql = "SELECT MATERIAL.ID_MATERIAL, MATERIAL.TITULO_MATERIA,
               MATERIAL.DESCRICAO_MATERIA, MATERIAL.DATA_CAD,
               CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI,
               NIVEL_ENSINO.NOME_NIVEL
        FROM MATERIAL_SALVO
        INNER JOIN MATERIAL ON MATERIAL_SALVO.COD_MATERIAL = MATERIAL.ID_MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        INNER JOIN NIVEL_ENSINO ON MATERIAL.COD_NIVEL = NIVEL_ENSINO.ID_NIVEL
        WHERE MATERIAL_SALVO.COD_PASTA = ?
        AND MATERIAL_SALVO.COD_USU = ?
        ORDER BY MATERIAL_SALVO.DATA_SALVO DESC";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_pasta, $id_usuario);

$stmt->execute();

$materiais = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/navbar.css">

    <title><?php echo htmlspecialchars($pasta['NOME_PASTA']); ?></title>

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


<main class="pasta-salva">

    <a href="materiaisSalvos.php">

        <i class="bx bx-arrow-back"></i>

        Voltar

    </a>


    <h1>

        <i class="bx bx-folder"></i>

        <?php echo htmlspecialchars($pasta['NOME_PASTA']); ?>

    </h1>


    <div id="materiaisPasta">

        <?php

        if($materiais->num_rows > 0){

            while($material = $materiais->fetch_assoc()){

                echo "<a href='material.php?id=" . $material['ID_MATERIAL'] . "' class='card-material'>";

                echo "<h3>" . htmlspecialchars($material['TITULO_MATERIA']) . "</h3>";

                echo "<p>" .
                    htmlspecialchars($material['NOME_DISCI']) .
                    " • " .
                    htmlspecialchars($material['NOME_CONTEUDO']) .
                "</p>";

                echo "<p>" .
                    htmlspecialchars($material['NOME_NIVEL']) .
                "</p>";

                if(!empty($material['DESCRICAO_MATERIA'])){

                    echo "<p>" .
                        htmlspecialchars($material['DESCRICAO_MATERIA']) .
                    "</p>";

                }

                echo "<p>" .
                    date("d/m/Y", strtotime($material['DATA_CAD'])) .
                "</p>";

                echo "</a>";

            }

        } else {

            echo "<p>Nenhum material salvo nesta pasta.</p>";

        }

        ?>

    </div>


</main>


</body>

</html>

<?php

$stmt->close();

?>