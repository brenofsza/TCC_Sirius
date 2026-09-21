<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo json_encode([
        "resposta" => "NAO_LOGADO"
    ]);

    exit;

}


$id_usuario = $_SESSION['id_usuario'];

$id_planejamento = $_POST['id_planejamento'] ?? '';
$acao = $_POST['acao'] ?? '';


if($id_planejamento == ''){

    echo json_encode([
        "resposta" => "ID_INVALIDO"
    ]);

    exit;

}


// salva as alterações

if($acao == "salvar"){

    $titulo = $_POST['titulo'] ?? '';
    $assunto = $_POST['assunto'] ?? '';
    $data = $_POST['data'] ?? '';
    $hora_inicio = $_POST['hora_inicio'] ?? '';
    $hora_fim = $_POST['hora_fim'] ?? '';
    $sala = $_POST['sala'] ?? '';

    $materiais = $_POST['materiais'] ?? '';


    if($titulo == '' || $data == '' || $hora_inicio == '' || $hora_fim == '' || $sala == ''){

        echo json_encode([
            "resposta" => "DADOS_INVALIDOS"
        ]);

        exit;

    }


    // verifica se a aula pertence ao usuário

    $sql = "SELECT ID_PLANEJAMENTO
            FROM PLANEJAMENTO
            WHERE ID_PLANEJAMENTO = ? AND COD_USU = ?";


    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("ii", $id_planejamento, $id_usuario);

    $stmt->execute();

    $resultado = $stmt->get_result();


    if($resultado->num_rows == 0){

        echo json_encode([
            "resposta" => "AULA_INVALIDA"
        ]);

        exit;

    }


    $stmt->close();


    // atualiza a aula

    $sql = "UPDATE PLANEJAMENTO
            SET TITULO_PLAN = ?,
                ASSUNTO = ?,
                DATA_AULA = ?,
                HORA_INICIO = ?,
                HORA_FIM = ?,
                SALA = ?
            WHERE ID_PLANEJAMENTO = ?
            AND COD_USU = ?";


    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "ssssssii",
        $titulo,
        $assunto,
        $data,
        $hora_inicio,
        $hora_fim,
        $sala,
        $id_planejamento,
        $id_usuario
    );


    if(!$stmt->execute()){

        echo json_encode([
            "resposta" => "ERRO"
        ]);

        exit;

    }


    $stmt->close();


    // remove os materiais antigos

    $sql = "DELETE FROM PLANEJAMENTO_MATERIAL
            WHERE COD_PLANEJAMENTO = ?";


    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("i", $id_planejamento);

    $stmt->execute();

    $stmt->close();


    // adiciona novamente os materiais selecionados

    if($materiais != ''){

        $listaMateriais = explode(",", $materiais);

        $sql = "INSERT INTO PLANEJAMENTO_MATERIAL
                (COD_PLANEJAMENTO, COD_MATERIAL)
                VALUES (?, ?)";


        $stmt = $conexao->prepare($sql);


        foreach($listaMateriais as $id_material){

            $id_material = intval($id_material);


            if($id_material > 0){

                $stmt->bind_param(
                    "ii",
                    $id_planejamento,
                    $id_material
                );

                $stmt->execute();

            }

        }


        $stmt->close();

    }


    echo json_encode([
        "resposta" => "OK!"
    ]);

    exit;

}


// busca os dados da aula

$sql = "SELECT *
        FROM PLANEJAMENTO
        WHERE ID_PLANEJAMENTO = ? AND COD_USU = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("ii", $id_planejamento, $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){

    echo json_encode([
        "resposta" => "AULA_INVALIDA"
    ]);

    exit;

}


$aula = $resultado->fetch_assoc();

$stmt->close();


// busca os materiais da aula

$sql = "SELECT MATERIAL.ID_MATERIAL, MATERIAL.TITULO_MATERIA
        FROM PLANEJAMENTO_MATERIAL
        INNER JOIN MATERIAL
        ON PLANEJAMENTO_MATERIAL.COD_MATERIAL = MATERIAL.ID_MATERIAL
        WHERE PLANEJAMENTO_MATERIAL.COD_PLANEJAMENTO = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_planejamento);

$stmt->execute();

$resultado = $stmt->get_result();


$materiais = [];


while($material = $resultado->fetch_assoc()){

    $materiais[] = $material;

}


$stmt->close();


$aula['MATERIAIS'] = $materiais;


echo json_encode($aula);

?>