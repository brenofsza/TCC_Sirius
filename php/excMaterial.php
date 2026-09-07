<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    header("Location: ../front/logar.php");

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_material = $_POST['id_material'] ?? '';


if($id_material == ''){

    header("Location: ../front/pesquisar.php");

    exit;

}


// verifica se o material pertence ao usuário logado

$sql = "SELECT CAMINHO_ARQUIVO
        FROM MATERIAL
        WHERE ID_MATERIAL = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_material, $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    header("Location: ../front/pesquisar.php");

    exit;

}


$material = $resultado->fetch_assoc();

$stmt->close();


// exclui o material do banco

$sql = "DELETE FROM MATERIAL
        WHERE ID_MATERIAL = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_material, $id_usuario);


if($stmt->execute()){

    // exclui o arquivo do servidor

    $arquivo = "../" . $material['CAMINHO_ARQUIVO'];

    if(file_exists($arquivo)){

        unlink($arquivo);

    }

}


$stmt->close();


header("Location: ../front/perfil.php");

exit;

?>