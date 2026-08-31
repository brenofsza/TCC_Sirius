<?php
include "conexao.php";
session_start();


$id = $_SESSION['id_usuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$username = $_POST['username'];
$descricao = trim($_POST['descricao']);

// ve se tem email cadastrado
if($_SESSION['email'] != $email){
    $sql = "SELECT ID_USU FROM USUARIO WHERE EMAIL_USU = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "EMAIL_EXISTE";
        exit;
    }
    $stmt->close();
}

// ve se tem o user cadastrado
if($_SESSION['username'] != $username){
    $sql2 = "SELECT ID_USU FROM USUARIO WHERE USERNAME = ?";
    $stmt2 = $conexao->prepare($sql2);
    $stmt2->bind_param("s", $username);
    $stmt2->execute();
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {
        echo "USER_EXISTE";
        exit;
    }
    $stmt2->close();
}


$sql3 = "UPDATE USUARIO SET EMAIL_USU = ?, NOME_USU = ?, USERNAME = ?, DESCRICAO_USU = ? WHERE ID_USU = ?";
$stmt3 = $conexao->prepare($sql3);
$stmt3->bind_param("ssssi", $email, $nome, $username, $descricao, $id);

if ($stmt3->execute()) {
    
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['descricao'] = $descricao;
    
    echo "OK!";
} else {
    echo "ERRO_SALVAR";
}

$stmt3->close();
?>