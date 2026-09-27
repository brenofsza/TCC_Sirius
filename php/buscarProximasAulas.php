<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$id_usuario = $_SESSION['id_usuario'];


$sql = "SELECT *
        FROM PLANEJAMENTO
        WHERE COD_USU = ?
        AND (DATA_AULA > CURDATE()
            OR (DATA_AULA = CURDATE() AND HORA_FIM > ADDTIME(CURTIME(), '-00:01:00')))
        ORDER BY DATA_AULA, HORA_INICIO
        LIMIT 5";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


$aulas = [];


while($aula = $resultado->fetch_assoc()){

    $aulas[] = $aula;

}


echo json_encode($aulas);


$stmt->close();

?>