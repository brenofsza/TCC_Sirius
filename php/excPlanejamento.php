<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO_LOGADO";

    exit;
}


$id_usuario = $_SESSION['id_usuario'];
$id_planejamento = $_POST['id_planejamento'] ?? '';


if($id_planejamento == ''){

    echo "DADOS_INVALIDOS";

    exit;

}


$sql = "DELETE FROM PLANEJAMENTO_MATERIAL
        WHERE COD_PLANEJAMENTO = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_planejamento);

$stmt->execute();

$stmt->close();


$sql = "DELETE FROM PLANEJAMENTO
        WHERE ID_PLANEJAMENTO = ?
        AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_planejamento,
    $id_usuario
);


if($stmt->execute()){

    if($stmt->affected_rows > 0){

        echo "OK!";

    } else {

        echo "NAO_ENCONTRADA";

    }

} else {

    echo "ERRO";

}


$stmt->close();

?>