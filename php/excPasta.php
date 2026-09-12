<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO_LOGADO";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_pasta = $_POST['id_pasta'] ?? '';


if($id_pasta == ''){

    echo "DADOS_INVALIDOS";

    exit;

}


// verifica se a pasta pertence ao usuário

$sql = "SELECT ID_PASTA, NOME_PASTA
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


$pasta = $resultado->fetch_assoc();

$stmt->close();


// não permite excluir a pasta Favoritos

if($pasta['NOME_PASTA'] == 'Favoritos'){

    echo "NAO_PERMITIDO";

    exit;

}


// exclui os materiais salvos nesta pasta

$sql = "DELETE FROM MATERIAL_SALVO
        WHERE COD_PASTA = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_pasta, $id_usuario);

$stmt->execute();

$stmt->close();


// exclui a pasta

$sql = "DELETE FROM PASTA
        WHERE ID_PASTA = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_pasta, $id_usuario);


if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>