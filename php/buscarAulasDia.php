<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$data = $_POST['data'] ?? '';


if($data == ''){

    echo json_encode([]);

    exit;

}


$sql = "SELECT *
        FROM PLANEJAMENTO
        WHERE COD_USU = ?
        AND DATA_AULA = ?
        ORDER BY HORA_INICIO";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("is", $id_usuario, $data);

$stmt->execute();

$resultado = $stmt->get_result();


$aulas = [];


while($aula = $resultado->fetch_assoc()){

    $id_planejamento = $aula['ID_PLANEJAMENTO'];

    $sqlMateriais = "SELECT MATERIAL.ID_MATERIAL, MATERIAL.TITULO_MATERIA
                     FROM PLANEJAMENTO_MATERIAL
                     INNER JOIN MATERIAL
                     ON PLANEJAMENTO_MATERIAL.COD_MATERIAL = MATERIAL.ID_MATERIAL
                     WHERE PLANEJAMENTO_MATERIAL.COD_PLANEJAMENTO = ?";

    $stmtMateriais = $conexao->prepare($sqlMateriais);

    $stmtMateriais->bind_param("i", $id_planejamento);

    $stmtMateriais->execute();

    $resultadoMateriais = $stmtMateriais->get_result();


    $materiais = [];


    while($material = $resultadoMateriais->fetch_assoc()){

        $materiais[] = $material;

    }


    $stmtMateriais->close();


    $aula['MATERIAIS'] = $materiais;

    $aulas[] = $aula;

}


echo json_encode($aulas);


$stmt->close();

?>