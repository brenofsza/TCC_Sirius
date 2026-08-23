<?php
include("conexao.php");

$nome = trim($_POST["nome"]);

$sql = "SELECT ID_DISCI FROM DISCIPLINA 
        WHERE NOME_DISCI = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $nome);

$stmt->execute();

$resultado = $stmt->get_result();

// ve se a disci ja existe 
if($resultado->num_rows > 0){
    echo "EXISTE";
    exit;
}
//cria disci nova
$sql = "INSERT INTO DISCIPLINA (NOME_DISCI)
        VALUES (?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $nome);

if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}

?>