<?php
session_start();
include("conexao.php");

$id_usuario = $_SESSION['id_usuario'];
$id_destino = $_POST['id_usuario'] ?? '';


if($id_destino == ''){
    echo "ERRO";
    exit;
}


// verifica a conexao nos dois sentidos
$sql = "SELECT STATUS_LIGACAO
        FROM LIGACAO
        WHERE (COD_USU = ? AND COD_USU_DESTINO = ?)
        OR (COD_USU = ? AND COD_USU_DESTINO = ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "iiii",
    $id_usuario,
    $id_destino,
    $id_destino,
    $id_usuario
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