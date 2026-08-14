<?php
include "conexao.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$username = $_POST['username'];

$sql = "UPDATE USUARIO SET EMAIL_USU='$email',
        NOME_USU='$nome', USERNAME='$username' WHERE ID_USUARIO='$id'";
        mysqli_query($conexao,$sql);

header("Location: usuarios.php");
?>