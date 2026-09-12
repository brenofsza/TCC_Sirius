<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO_LOGADO";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_pasta = $_POST['id_pasta'] ?? '';

$nome_pasta = trim($_POST['nome_pasta'] ?? '');


if($id_pasta == '' || $nome_pasta == ''){

    echo "NOME_VAZIO";

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


// não permite renomear a pasta Favoritos

if($pasta['NOME_PASTA'] == 'Favoritos'){

    echo "NAO_PERMITIDO";

    exit;

}


// verifica se já existe outra pasta com esse nome

$sql = "SELECT ID_PASTA
        FROM PASTA
        WHERE COD_USU = ?
        AND NOME_PASTA = ?
        AND ID_PASTA != ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("isi", $id_usuario, $nome_pasta, $id_pasta);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    echo "EXISTE";

    exit;

}

$stmt->close();


// renomeia a pasta

$sql = "UPDATE PASTA
        SET NOME_PASTA = ?
        WHERE ID_PASTA = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("sii", $nome_pasta, $id_pasta, $id_usuario);


if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>