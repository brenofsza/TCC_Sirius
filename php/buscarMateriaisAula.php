<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$pesquisa = trim($_POST['pesquisa'] ?? '');

$busca = "%" . $pesquisa . "%";


$sql = "SELECT MATERIAL.ID_MATERIAL, MATERIAL.TITULO_MATERIA,
            CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        WHERE MATERIAL.STATUS_MATERIA = 'PUBLICO'
        AND (
            MATERIAL.TITULO_MATERIA LIKE ?
            OR MATERIAL.DESCRICAO_MATERIA LIKE ?
            OR CONTEUDO.NOME_CONTEUDO LIKE ?
            OR DISCIPLINA.NOME_DISCI LIKE ?
        )
        ORDER BY MATERIAL.DATA_CAD DESC";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssss",
    $busca,
    $busca,
    $busca,
    $busca
);


$stmt->execute();

$resultado = $stmt->get_result();


$materiais = [];


while($material = $resultado->fetch_assoc()){

    $materiais[] = $material;

}


echo json_encode($materiais);


$stmt->close();

?>