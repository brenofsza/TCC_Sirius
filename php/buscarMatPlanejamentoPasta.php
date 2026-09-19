<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "<p>Faça login para visualizar os materiais.</p>";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];
$id_pasta = $_POST['id_pasta'] ?? '';


if($id_pasta == ''){

    echo "<p>Pasta inválida.</p>";

    exit;

}


$sql = "SELECT MATERIAL.ID_MATERIAL, MATERIAL.TITULO_MATERIA,
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

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    while($material = $resultado->fetch_assoc()){

        echo "<div class='material-pasta-planejamento'>";

        echo "<input type='checkbox' class='material-pasta-checkbox' value='" . $material['ID_MATERIAL'] . "'>";

        echo "<div>";

        echo "<h3>" . htmlspecialchars($material['TITULO_MATERIA']) . "</h3>";

        echo "<p>" .
            htmlspecialchars($material['NOME_DISCI']) .
            " • " .
            htmlspecialchars($material['NOME_CONTEUDO']) .
        "</p>";

        echo "<p>" .
            htmlspecialchars($material['NOME_NIVEL']) .
        "</p>";

        echo "</div>";

        echo "</div>";

    }

} else {

    echo "<p>Nenhum material salvo nesta pasta.</p>";

}


$stmt->close();

?>