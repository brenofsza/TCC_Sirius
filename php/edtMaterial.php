<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['id_usuario'])){
    echo "nao_autorizado";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$id_material = $_POST['id_material'] ?? '';
$titulo = trim($_POST['titulo'] ?? '');
$id_disci = $_POST['id_disci'] ?? '';
$id_cont = $_POST['id_cont'] ?? '';
$nivel = $_POST['nivel'] ?? '';
$status = $_POST['status'] ?? '';
$descricao = trim($_POST['descricao'] ?? '');


if(
    $id_material == '' ||
    $titulo == '' ||
    $id_disci == '' ||
    $id_cont == '' ||
    $nivel == '' ||
    $status == ''
){

    echo "campos_vazios";
    exit;

}


if(
    $status != 'PUBLICO' &&
    $status != 'PRIVADO' &&
    $status != 'CONEXOES'
){

    echo "erro_dados";
    exit;

}


if(
    $nivel != '1' &&
    $nivel != '2' &&
    $nivel != '3' &&
    $nivel != '4'
){

    echo "erro_dados";
    exit;

}


$sqlDono = "SELECT ID_MATERIAL
            FROM MATERIAL
            WHERE ID_MATERIAL = ?
            AND COD_USU = ?";

$stmtDono = $conexao->prepare($sqlDono);

$stmtDono->bind_param(
    "ii",
    $id_material,
    $id_usuario
);

$stmtDono->execute();

$resultadoDono = $stmtDono->get_result();


if($resultadoDono->num_rows == 0){

    echo "nao_autorizado";

    $stmtDono->close();

    exit;

}

$stmtDono->close();


$sqlCont = "SELECT ID_CONTEUDO
            FROM CONTEUDO
            WHERE ID_CONTEUDO = ?
            AND COD_DISCI = ?";

$stmtCont = $conexao->prepare($sqlCont);

$stmtCont->bind_param(
    "ii",
    $id_cont,
    $id_disci
);

$stmtCont->execute();

$resultadoCont = $stmtCont->get_result();


if($resultadoCont->num_rows == 0){

    echo "conteudo_invalido";

    $stmtCont->close();

    exit;

}

$stmtCont->close();


$arquivoNovo = isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK;


if($arquivoNovo){

    $arquivo = $_FILES['arquivo'];

    $tamMax = 10 * 1024 * 1024;

    $extPermitidas = [
        'pdf',
        'jpg',
        'jpeg',
        'png',
        'webp',
        'ppt',
        'pptx'
    ];

    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    if($arquivo['size'] > $tamMax){

        echo "erro_tamanho";
        exit;

    }

    if(!in_array($extensao, $extPermitidas)){

        echo "erro_extensao";
        exit;

    }

}


if($arquivoNovo){

    $sqlArquivo = "SELECT CAMINHO_ARQUIVO
                   FROM MATERIAL
                   WHERE ID_MATERIAL = ?
                   AND COD_USU = ?";

    $stmtArquivo = $conexao->prepare($sqlArquivo);

    $stmtArquivo->bind_param(
        "ii",
        $id_material,
        $id_usuario
    );

    $stmtArquivo->execute();

    $resultadoArquivo = $stmtArquivo->get_result();
    $materialArquivo = $resultadoArquivo->fetch_assoc();

    $stmtArquivo->close();


    $pastaUpload = "uploads/materiais/";

    $nvNome = uniqid("material_", true) . "." . $extensao;

    $caminhoCompleto = $pastaUpload . $nvNome;

    if(!move_uploaded_file($arquivo['tmp_name'], "../" . $caminhoCompleto)){

        echo "erro_upload";
        exit;

    }

}


if($arquivoNovo){

    $sql = "UPDATE MATERIAL
            SET COD_CONTEUDO = ?,
                COD_NIVEL = ?,
                TITULO_MATERIA = ?,
                DESCRICAO_MATERIA = ?,
                STATUS_MATERIA = ?,
                CAMINHO_ARQUIVO = ?,
                NOME_ARQUIVO = ?
            WHERE ID_MATERIAL = ?
            AND COD_USU = ?";

    $stmt = $conexao->prepare($sql);

    $nomeArquivo = $arquivo['name'];

    $stmt->bind_param(
        "iisssssii",
        $id_cont,
        $nivel,
        $titulo,
        $descricao,
        $status,
        $caminhoCompleto,
        $nomeArquivo,
        $id_material,
        $id_usuario
    );

} else {

    $sql = "UPDATE MATERIAL
            SET COD_CONTEUDO = ?,
                COD_NIVEL = ?,
                TITULO_MATERIA = ?,
                DESCRICAO_MATERIA = ?,
                STATUS_MATERIA = ?
            WHERE ID_MATERIAL = ?
            AND COD_USU = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "iisssii",
        $id_cont,
        $nivel,
        $titulo,
        $descricao,
        $status,
        $id_material,
        $id_usuario
    );

}


if($stmt->execute()){

    if($arquivoNovo && !empty($materialArquivo['CAMINHO_ARQUIVO'])){

        $arquivoAntigo = "../" . $materialArquivo['CAMINHO_ARQUIVO'];

        if(file_exists($arquivoAntigo)){

            unlink($arquivoAntigo);

        }

    }

    echo "OK!";

} else {

    echo "erro_banco";

}


$stmt->close();

?>