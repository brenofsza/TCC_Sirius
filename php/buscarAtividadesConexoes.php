<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([]);

    exit;

}


$id_usuario = $_SESSION['id_usuario'];


$sql = "SELECT MATERIAL.ID_MATERIAL,
               MATERIAL.TITULO_MATERIA,
               MATERIAL.DATA_CAD,
               USUARIO.ID_USU,
               USUARIO.NOME_USU,
               USUARIO.USERNAME,
               USUARIO.FOTO_USU
        FROM LIGACAO
        INNER JOIN MATERIAL
        ON MATERIAL.COD_USU = 
            CASE
                WHEN LIGACAO.COD_USU = ? THEN LIGACAO.COD_USU_DESTINO
                ELSE LIGACAO.COD_USU
            END
        INNER JOIN USUARIO
        ON MATERIAL.COD_USU = USUARIO.ID_USU
        WHERE (LIGACAO.COD_USU = ? OR LIGACAO.COD_USU_DESTINO = ?)
        AND LIGACAO.STATUS_LIGACAO = 'ACEITA'
        AND MATERIAL.STATUS_MATERIA = 'PUBLICO'
        ORDER BY MATERIAL.DATA_CAD DESC
        LIMIT 5";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "iii",
    $id_usuario,
    $id_usuario,
    $id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();


$atividades = [];


while($atividade = $resultado->fetch_assoc()){

    $atividades[] = $atividade;

}


echo json_encode($atividades);


$stmt->close();

?>