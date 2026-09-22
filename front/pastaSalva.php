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
    <link rel="stylesheet" href="../css/materiaisSalvos.css">
    <title><?php echo htmlspecialchars($pasta['NOME_PASTA']); ?></title>
    <link rel="icon" type="image/png" href="../img/preBancaTCC.jpg">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>


<main class="pasta-salva">

    <a href="materiaisSalvos.php">

        <i class="bx bx-arrow-back"></i>

        Voltar

    </a>


    <h1>

        <i class="bx bx-folder"></i>

        <?php echo htmlspecialchars($pasta['NOME_PASTA']); ?>


        <?php if($pasta['NOME_PASTA'] != 'Favoritos'){ ?>

            <button type="button" id="renomearPasta">

                <i class="bx bx-edit"></i>

                Renomear

            </button>


            <button type="button" id="excluirPasta">

                <i class="bx bx-trash"></i>

                Excluir

            </button>

        <?php } ?>

    </h1>


    <div id="materiaisPasta">

        <?php

        if($materiais->num_rows > 0){

            while($material = $materiais->fetch_assoc()){

                echo "<div class='card-material'>";

                echo "<a href='material.php?id=" . $material['ID_MATERIAL'] . "' class='info-material'>";

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


                echo "<button type='button' class='removerMaterial' data-id='" . $material['ID_MATERIAL'] . "'>";

                echo "<i class='bx bx-trash'></i>";

                echo "</button>";


                echo "</div>";

            }

        } else {

            echo "<p>Nenhum material salvo nesta pasta.</p>";

        }

        ?>

    </div>


</main>


<dialog id="modalRenomearPasta">

    <div class="modal-renomear-pasta">

        <button type="button" id="fecharRenomearPasta">

            <i class="bx bx-x"></i>

        </button>


        <h2>Renomear pasta</h2>


        <input
            type="text"
            id="novoNomePasta"
            maxlength="50"
            value="<?php echo htmlspecialchars($pasta['NOME_PASTA']); ?>"
        >


        <button type="button" id="salvarNomePasta">

            Salvar

        </button>


        <p id="mensagemRenomear"></p>

    </div>

</dialog>


<dialog id="modalExcluirPasta">

    <div class="modal-excluir-pasta">

        <button type="button" id="fecharExcluirPasta">

            <i class="bx bx-x"></i>

        </button>


        <h2>Excluir pasta?</h2>


        <p>

            Tem certeza que deseja excluir esta pasta?

        </p>


        <p>

            Os materiais salvos nela serão removidos da pasta, mas os materiais originais não serão excluídos.

        </p>


        <button type="button" id="confirmarExcluirPasta">

            Excluir

        </button>


        <button type="button" id="cancelarExcluirPasta">

            Cancelar

        </button>


        <p id="mensagemExcluir"></p>

    </div>

</dialog>

<dialog id="modalRemoverMaterial">

    <div class="modal-remover-material">

        <button type="button" id="fecharRemoverMaterial">

            <i class="bx bx-x"></i>

        </button>


        <h2>Remover material?</h2>


        <p>

            Tem certeza que deseja remover este material desta pasta?

        </p>


        <p>

            O material original não será excluído.

        </p>


        <button type="button" id="confirmarRemoverMaterial">

            Remover

        </button>


        <button type="button" id="cancelarRemoverMaterial">

            Cancelar

        </button>


        <p id="mensagemRemover"></p>

    </div>

</dialog>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/pastaSalva.js"></script>
</body>

</html>

<?php

$stmt->close();

?>
