<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "BD_Sirius";

$conexao = new mysqli($host, $usuario, $senha, $banco, 3306);

$conexao->set_charset('utf8mb4');


if($conexao->connect_error){

    die("Erro na conexão: ". $conexao->connect_error);

}

?>
