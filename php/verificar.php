<?php

session_start();

include("conexao.php");


$email = $_POST["email"];
$senha = $_POST["senha"];

$sql = "SELECT * FROM USUARIO WHERE EMAIL_USU = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    
    //pegando o usuário, o id e o tipo de usuario do banco
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