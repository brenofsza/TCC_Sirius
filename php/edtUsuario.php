<?php
include "conexao.php";
session_start();

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$username = $_POST['username'];


if($_SESSION['email'] != $email){
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
}

if($_SESSION['username'] != $username){
//confirma se existe o user cadastrado ou nao
$sql2 = "SELECT ID_USU FROM USUARIO WHERE USERNAME = ?";
$stmt2 = $conexao->prepare($sql2);
$stmt2->bind_param("s", $username);
$stmt2->execute();
$stmt2->store_result();

if ($stmt2->num_rows > 0) {
    echo "USER_EXISTE";
    exit;
}}

$sql = "UPDATE USUARIO SET EMAIL_USU='$email',
        NOME_USU='$nome', USERNAME='$username' WHERE ID_USUARIO='$id'";
        mysqli_query($conexao,$sql);

if ($stmt->execute()) {
    echo "OK!";
} else {
    echo "ERRO: " . $stmt->error;
}        

header("Location: ../front/perfil.php");
?>