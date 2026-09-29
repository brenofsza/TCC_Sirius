<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['id_usuario'])){
    echo "nao_autorizado";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$titulo = trim($_POST["titulo"] ?? '');
$conteudo = $_POST["id_cont"] ?? '';
$nivel = $_POST["nivel"] ?? '';
$status = $_POST["status"] ?? '';
$descricao = trim($_POST["descricao"] ?? '');

if(
    $titulo == '' ||
    $conteudo == '' ||
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

if(!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK){
    echo "erro_arquivo";
    exit;
}

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

$extensao = strtolower(
    pathinfo($arquivo['name'], PATHINFO_EXTENSION)
);

if($arquivo['size'] > $tamMax){
    echo "erro_tamanho";
    exit;
}

if(!in_array($extensao, $extPermitidas)){
    echo "erro_extensao";
    exit;
}

$pastaUpload = "uploads/materiais/";

$nvNome = uniqid("material_", true) . "." . $extensao;

$caminhoCompleto = $pastaUpload . $nvNome;

if(move_uploaded_file(
    $arquivo['tmp_name'],
    "../" . $caminhoCompleto
)){

    $nomeArquivo = $arquivo['name'];
    $data = date("Y-m-d H:i:s");

    $sql = "INSERT INTO MATERIAL
            (COD_USU, COD_CONTEUDO, COD_NIVEL, TITULO_MATERIA,
            DESCRICAO_MATERIA, CAMINHO_ARQUIVO, NOME_ARQUIVO,
            DATA_CAD, STATUS_MATERIA)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "iiissssss",
        $id_usuario,
        $conteudo,
        $nivel,
        $titulo,
        $descricao,
        $caminhoCompleto,
        $nomeArquivo,
        $data,
        $status
    );

    if($stmt->execute()){
        echo "OK!";
    } else {
        echo "erro_banco";
    }

    $stmt->close();

} else {
    echo "erro_upload";
}

?>