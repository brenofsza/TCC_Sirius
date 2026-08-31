<?php
session_start();
include("conexao.php");

$id_usuario = $_SESSION['id_usuario'];
$id_destino = $_POST['id_usuario'] ?? '';


if($id_destino == ''){
    echo "ERRO";
    exit;
}


// verifica a conexao
$sql = "SELECT STATUS_LIGACAO
        FROM LIGACAO
        WHERE COD_USU = ?
        AND COD_USU_DESTINO = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_usuario,
    $id_destino
);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    $ligacao = $resultado->fetch_assoc();

    if($ligacao['STATUS_LIGACAO'] == 'PENDENTE'){

        echo "PENDENTE";

    } else if($ligacao['STATUS_LIGACAO'] == 'ACEITA'){

        echo "ACEITA";

    } else {

        echo "NENHUMA";

    }

} else {

    echo "NENHUMA";

}


$stmt->close();

?>