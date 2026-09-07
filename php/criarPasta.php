<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO_LOGADO";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$nome_pasta = trim($_POST['nome_pasta'] ?? '');


if($nome_pasta == ''){

    echo "NOME_VAZIO";

    exit;

}


// verifica se o usuário já possui uma pasta com esse nome

$sql = "SELECT ID_PASTA
        FROM PASTA
        WHERE COD_USU = ? AND NOME_PASTA = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("is", $id_usuario, $nome_pasta);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    echo "EXISTE";

    exit;

}

$stmt->close();


// cria a pasta

$sql = "INSERT INTO PASTA(COD_USU, NOME_PASTA)
        VALUES (?, ?)";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("is", $id_usuario, $nome_pasta);


if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>