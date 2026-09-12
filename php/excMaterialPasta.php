<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO_LOGADO";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_material = $_POST['id_material'] ?? '';

$id_pasta = $_POST['id_pasta'] ?? '';


if($id_material == '' || $id_pasta == ''){

    echo "DADOS_INVALIDOS";

    exit;

}


// verifica se o material está salvo nessa pasta pelo usuário

$sql = "SELECT ID_SALVO
        FROM MATERIAL_SALVO
        WHERE COD_USU = ?
        AND COD_MATERIAL = ?
        AND COD_PASTA = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("iii", $id_usuario, $id_material, $id_pasta);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    echo "NAO_ENCONTRADO";

    exit;

}

$stmt->close();


// remove somente o material desta pasta

$sql = "DELETE FROM MATERIAL_SALVO
        WHERE COD_USU = ?
        AND COD_MATERIAL = ?
        AND COD_PASTA = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("iii", $id_usuario, $id_material, $id_pasta);


if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>