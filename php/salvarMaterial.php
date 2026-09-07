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


// verifica se a pasta pertence ao usuário

$sql = "SELECT ID_PASTA
        FROM PASTA
        WHERE ID_PASTA = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_pasta, $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    echo "PASTA_INVALIDA";

    exit;

}

$stmt->close();


// verifica se o material já está salvo nessa pasta

$sql = "SELECT ID_SALVO
        FROM MATERIAL_SALVO
        WHERE COD_USU = ?
        AND COD_MATERIAL = ?
        AND COD_PASTA = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("iii", $id_usuario, $id_material, $id_pasta);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    echo "JA_SALVO";

    exit;

}

$stmt->close();


// salva o material

$sql = "INSERT INTO MATERIAL_SALVO
        (COD_USU, COD_MATERIAL, COD_PASTA, DATA_SALVO)
        VALUES (?, ?, ?, CURDATE())";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("iii", $id_usuario, $id_material, $id_pasta);


if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>