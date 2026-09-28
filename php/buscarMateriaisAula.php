<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$pesquisa = trim($_POST['pesquisa'] ?? '');

$busca = "%" . $pesquisa . "%";


$sql = "SELECT MATERIAL.ID_MATERIAL, MATERIAL.TITULO_MATERIA,
            MATERIAL.STATUS_MATERIA,
            CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        WHERE (
            MATERIAL.TITULO_MATERIA LIKE ?
            OR MATERIAL.DESCRICAO_MATERIA LIKE ?
            OR CONTEUDO.NOME_CONTEUDO LIKE ?
            OR DISCIPLINA.NOME_DISCI LIKE ?
        )
        AND (
            MATERIAL.STATUS_MATERIA = 'PUBLICO'
            OR (
                MATERIAL.STATUS_MATERIA = 'CONEXOES'
                AND (
                    MATERIAL.COD_USU = ?
                    OR EXISTS (
                        SELECT 1
                        FROM LIGACAO
                        WHERE STATUS_LIGACAO = 'ACEITA'
                        AND (
                            (COD_USU = ? AND COD_USU_DESTINO = MATERIAL.COD_USU)
                            OR
                            (COD_USU_DESTINO = ? AND COD_USU = MATERIAL.COD_USU)
                        )
                    )
                )
            )
        )
        ORDER BY MATERIAL.DATA_CAD DESC";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssssiii",
    $busca,
    $busca,
    $busca,
    $busca,
    $id_usuario,
    $id_usuario,
    $id_usuario
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