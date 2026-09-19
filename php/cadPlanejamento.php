<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "NAO_LOGADO";

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$titulo = $_POST['titulo'] ?? '';
$assunto = $_POST['assunto'] ?? '';
$data = $_POST['data'] ?? '';
$hora_inicio = $_POST['hora_inicio'] ?? '';
$hora_fim = $_POST['hora_fim'] ?? '';
$sala = $_POST['sala'] ?? '';

$materiais = $_POST['materiais'] ?? '';


if($titulo == '' || $data == '' || $hora_inicio == '' || $hora_fim == '' || $sala == ''){

    echo "DADOS_INVALIDOS";

    exit;

}


$status = "PLANEJADA";


$sql = "INSERT INTO PLANEJAMENTO
        (COD_USU, TITULO_PLAN, ASSUNTO, DATA_AULA, HORA_INICIO, HORA_FIM, SALA, STATUS_PLAN)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "isssssss",
    $id_usuario,
    $titulo,
    $assunto,
    $data,
    $hora_inicio,
    $hora_fim,
    $sala,
    $status
);


if($stmt->execute()){

    $id_planejamento = $conexao->insert_id;

    if($materiais != ''){

        $listaMateriais = explode(",", $materiais);

        $sqlMaterial = "INSERT INTO PLANEJAMENTO_MATERIAL
                        (COD_PLANEJAMENTO, COD_MATERIAL)
                        VALUES (?, ?)";

        $stmtMaterial = $conexao->prepare($sqlMaterial);

        foreach($listaMateriais as $id_material){

            $id_material = intval($id_material);

            if($id_material > 0){

                $stmtMaterial->bind_param(
                    "ii",
                    $id_planejamento,
                    $id_material
                );

                $stmtMaterial->execute();

            }

        }

        $stmtMaterial->close();

    }

    echo "OK!";

} else {

    echo "ERRO";

}


$stmt->close();

?>