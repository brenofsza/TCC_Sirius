<?php

session_start();

include("conexao.php");


$usuario = $_POST["email"]; 
$senha = $_POST["senha"];


$sql = "SELECT * FROM USUARIO WHERE EMAIL_USU = ? OR USERNAME = ?";

$stmt = $conexao->prepare($sql);


$stmt->bind_param("ss", $usuario, $usuario);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    $dados = $resultado->fetch_assoc();

    if(password_verify($senha, $dados['SENHA_USU'])){
    
        $_SESSION["nome"] = $dados["NOME_USU"];
        $_SESSION["id_usuario"] = $dados["ID_USU"];
        $_SESSION["username"] = $dados["USERNAME"];

        echo "ok";

    }else{
        echo "erro";
    }
}else{
    echo "erro";
}

?>
