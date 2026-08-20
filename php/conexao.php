<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "BD_SIRIUS";

$conexao = new mysqli($host, $usuario, $senha, $banco, 3306);


if($conexao->connect_error){

    die("Erro na conexão: ". $conexao->connect_error);

}

?>