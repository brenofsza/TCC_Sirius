<?php
include("conexao.php");

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$confirmaSenha = $_POST["confirmaSenha"];
$username = $_POST["username"];

if ($senha !== $confirmaSenha) {
    echo "SENHA_ERRO";
    exit;
}

//confirma se existe o email cadastrado ou nao
$sql = "SELECT ID_USU FROM USUARIO WHERE EMAIL_USU = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "EMAIL_EXISTE";
    exit;
}

//confirma se existe o user cadastrado ou nao
$sql2 = "SELECT ID_USU FROM USUARIO WHERE USERNAME = ?";
$stmt2 = $conexao->prepare($sql2);
$stmt2->bind_param("s", $username);
$stmt2->execute();
$stmt2->store_result();

if ($stmt2->num_rows > 0) {
    echo "USER_EXISTE";
    exit;
}

// cad usuario
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO USUARIO(NOME_USU, EMAIL_USU, SENHA_USU, USERNAME) VALUES (?,?,?,?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $senhaHash, $username); 


if ($stmt->execute()) {
    echo "OK!";
    return;
} else {
    echo "ERRO: " . $stmt->error;
    return;
}
?>