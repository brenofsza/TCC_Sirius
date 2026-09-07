<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_material = $_POST['id_material'] ?? '';


if($id_material == ''){

    echo "NAO";

    exit;

}


$sql = "SELECT ID_SALVO
        FROM MATERIAL_SALVO
        WHERE COD_USU = ?
        AND COD_MATERIAL = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_usuario, $id_material);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    echo "SIM";

} else {

    echo "NAO";

}


$stmt->close();

?>