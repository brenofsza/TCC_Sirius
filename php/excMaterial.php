<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "nao_autorizado";
    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_material = $_POST['id_material'] ?? '';


if($id_material == ''){

    echo "id_invalido";
    exit;

}


// verifica se o material pertence ao usuário logado

$sql = "SELECT CAMINHO_ARQUIVO
        FROM MATERIAL
        WHERE ID_MATERIAL = ? AND COD_USU = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_material,
    $id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    echo "nao_autorizado";

    $stmt->close();

    exit;

}


$material = $resultado->fetch_assoc();

$stmt->close();


// exclui o material do banco

$sql = "DELETE FROM MATERIAL
        WHERE ID_MATERIAL = ? AND COD_USU = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_material,
    $id_usuario
);


if($stmt->execute()){

    // exclui o arquivo do servidor

    $arquivo = "../" . $material['CAMINHO_ARQUIVO'];

    if(
        !empty($material['CAMINHO_ARQUIVO']) &&
        file_exists($arquivo)
    ){

        unlink($arquivo);

    }

    echo "OK!";

} else {

    echo "erro_banco";

}


$stmt->close();

?>