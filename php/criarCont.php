<?php

include("conexao.php");

$nome = trim($_POST["nome"]);
$disci = $_POST["disci"];

$sql = "SELECT ID_CONTEUDO FROM CONTEUDO
        WHERE NOME_CONTEUDO = ?
        AND COD_DISCI = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("si", $nome, $disci);

$stmt->execute();

$resultado = $stmt->get_result();

// vê se o cont já existe 
if($resultado->num_rows > 0){
    echo "EXISTE";
    exit;
}

// cria cont
$sql = "INSERT INTO CONTEUDO (COD_DISCI, NOME_CONTEUDO)
        VALUES (?, ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("is", $disci, $nome);

if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}

?>