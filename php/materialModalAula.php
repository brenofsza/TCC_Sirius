<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$id_material = $_POST['id_material'] ?? '';


if($id_material == ''){

    echo json_encode([]);

    exit;

}


$sql = "SELECT MATERIAL.*, CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI,
            NIVEL_ENSINO.NOME_NIVEL, USUARIO.NOME_USU
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        INNER JOIN NIVEL_ENSINO ON MATERIAL.COD_NIVEL = NIVEL_ENSINO.ID_NIVEL
        INNER JOIN USUARIO ON MATERIAL.COD_USU = USUARIO.ID_USU
        WHERE MATERIAL.ID_MATERIAL = ?
        AND MATERIAL.STATUS_MATERIA = 'PUBLICO'";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_material);

$stmt->execute();

$resultado = $stmt->get_result();


$material = $resultado->fetch_assoc();


if($material){

    echo json_encode($material);

} else {

    echo json_encode([]);

}


$stmt->close();

?>