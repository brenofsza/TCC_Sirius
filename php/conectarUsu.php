<?php

session_start();

include("conexao.php");


$id_usuario = $_SESSION['id_usuario'];
$id_destino = $_POST['id_usuario'] ?? '';


if($id_destino == ''){

    echo "ERRO";

    exit;

}


// verifica se ja existe uma ligacao
$sql = "SELECT ID_LIGACAO, STATUS_LIGACAO
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

    $stmt->close();


    // cancela a solicitacao pendente
    if($ligacao['STATUS_LIGACAO'] == 'PENDENTE'){

        $sql = "DELETE FROM LIGACAO
                WHERE ID_LIGACAO = ?";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param(
            "i",
            $ligacao['ID_LIGACAO']
        );

        if($stmt->execute()){

            echo "CANCELADO";

        } else {

            echo "ERRO";

        }

        $stmt->close();

        exit;

    }


    // desfaz uma conexao aceita
    if($ligacao['STATUS_LIGACAO'] == 'ACEITA'){

        $sql = "DELETE FROM LIGACAO
                WHERE ID_LIGACAO = ?";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param(
            "i",
            $ligacao['ID_LIGACAO']
        );

        if($stmt->execute()){

            echo "DESFEITO";

        } else {

            echo "ERRO";

        }

        $stmt->close();

        exit;

    }

}


// cria uma nova solicitacao
$data = date("Y-m-d");

$sql = "INSERT INTO LIGACAO
        (COD_USU, COD_USU_DESTINO, STATUS_LIGACAO, DATA_LIGACAO)
        VALUES (?, ?, 'PENDENTE', ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "iis",
    $id_usuario,
    $id_destino,
    $data
);


if($stmt->execute()){

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>