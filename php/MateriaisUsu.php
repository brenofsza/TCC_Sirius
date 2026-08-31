<?php

session_start();

include("conexao.php");

// aqui é para separar se é usuario exeterno ou se é a propria pessoa vendo seu 
// perfil na aba perfil
$id_usuario = $_POST['id_usuario'] ?? $_SESSION['id_usuario'];

$tipo = $_POST['tipo'] ?? 'publico';


// busca os materiais do usuario
$sql = "SELECT MATERIAL.*, CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI,
            NIVEL_ENSINO.NOME_NIVEL
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        INNER JOIN NIVEL_ENSINO ON MATERIAL.COD_NIVEL = NIVEL_ENSINO.ID_NIVEL
        WHERE MATERIAL.COD_USU = ?";


if($tipo == "publico"){

    $sql .= " AND MATERIAL.STATUS_MATERIA = 'PUBLICO'";

} else if($tipo == "privado"){

    $sql .= " AND MATERIAL.STATUS_MATERIA = 'PRIVADO'";

}


$sql .= " ORDER BY MATERIAL.DATA_CAD DESC";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    while($material = $resultado->fetch_assoc()){

        echo "<a href='../front/material.php?id=" . $material['ID_MATERIAL'] . "' class='card-material'>";

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

    if($tipo == "publico"){

        echo "<p>Nenhum material publico.</p>";

    } else {

        echo "<p>Nenhum material privado.</p>";

    }

}


$stmt->close();

?>