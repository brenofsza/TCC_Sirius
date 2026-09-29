<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['id_usuario'])){
    echo json_encode([
        "erro" => "nao_autorizado"
    ]);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_material = $_POST['id_material'] ?? '';

if($id_material == ''){
    echo json_encode([
        "erro" => "id_invalido"
    ]);
    exit;
}


$sql = "SELECT MATERIAL.ID_MATERIAL,
               MATERIAL.TITULO_MATERIA,
               MATERIAL.COD_CONTEUDO,
               MATERIAL.COD_NIVEL,
               MATERIAL.STATUS_MATERIA,
               MATERIAL.DESCRICAO_MATERIA,
               CONTEUDO.NOME_CONTEUDO,
               CONTEUDO.COD_DISCI,
               DISCIPLINA.NOME_DISCI
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        WHERE MATERIAL.ID_MATERIAL = ?
        AND MATERIAL.COD_USU = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_material,
    $id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    echo json_encode([
        "erro" => "nao_autorizado"
    ]);

    $stmt->close();

    exit;
}


$material = $resultado->fetch_assoc();


echo json_encode([
    "id_material" => $material['ID_MATERIAL'],
    "titulo" => $material['TITULO_MATERIA'],
    "id_cont" => $material['COD_CONTEUDO'],
    "cont" => $material['NOME_CONTEUDO'],
    "id_disci" => $material['COD_DISCI'],
    "disci" => $material['NOME_DISCI'],
    "nivel" => $material['COD_NIVEL'],
    "status" => $material['STATUS_MATERIA'],
    "descricao" => $material['DESCRICAO_MATERIA']
]);


$stmt->close();

?>