<?php
include("conexao.php");

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$confirmaSenha = $_POST["confirmaSenha"];

if ($senha !== $confirmaSenha) {
    echo "SENHA_ERRO";
    exit;
}

// Verifica se o e-mail já existe
$sql = "SELECT ID_USU FROM USUARIO WHERE EMAIL_USU = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "EMAIL_EXISTE";
    exit;
}

// Insere o novo usuário
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO USUARIO(NOME_USU, EMAIL_USU, SENHA_USU) VALUES (?,?,?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senhaHash);

if ($stmt->execute()) {
    echo "OK!";
} else {
    echo "erro";
}
?>