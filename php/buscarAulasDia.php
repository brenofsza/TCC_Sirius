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

    $aulas[] = $aula;

}


echo json_encode($aulas);


$stmt->close();

?>