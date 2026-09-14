r<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$mes = $_POST['mes'] ?? '';
$ano = $_POST['ano'] ?? '';


if($mes == '' || $ano == ''){

    echo json_encode([]);

    exit;

}


$sql = "SELECT *
        FROM PLANEJAMENTO
        WHERE COD_USU = ?
        AND MONTH(DATA_AULA) = ?
        AND YEAR(DATA_AULA) = ?
        ORDER BY DATA_AULA, HORA_INICIO";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("iii", $id_usuario, $mes, $ano);

$stmt->execute();

$resultado = $stmt->get_result();


$aulas = [];


while($aula = $resultado->fetch_assoc()){

    $aulas[] = $aula;

}


echo json_encode($aulas);


$stmt->close();

?>