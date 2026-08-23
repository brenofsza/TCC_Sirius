<?php

session_start();

include("conexao.php");

$id_usuario = $_SESSION['id_usuario'];

$titulo = trim($_POST["titulo"]);
$conteudo = $_POST["id_cont"];
$nivel = $_POST["nivel"];
$status = $_POST["status"];

if($titulo == '' || $conteudo == '' || $nivel == '' || $status == ''){
    echo "campos_vazios";
    exit;
}

if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
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

$extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

if ($arquivo['size'] > $tamMax) {
    echo "erro_tamanho";
    exit;
}

if (!in_array($extensao, $extPermitidas)) {
    echo "erro_extensao";
    exit;
}

$pastaUpload = "uploads/materiais/";

$nvNome = uniqid("material_", true) . "." . $extensao;

$caminhoCompleto = $pastaUpload . $nvNome;

if (move_uploaded_file($arquivo['tmp_name'], "../" . $caminhoCompleto)) {

    $nomeArquivo = $arquivo['name'];
    $data = date("Y-m-d");

    $sql = "INSERT INTO MATERIAL
            (COD_USU, COD_CONTEUDO, COD_NIVEL, TITULO_MATERIA,
            CAMINHO_ARQUIVO, NOME_ARQUIVO, DATA_CAD, STATUS_MATERIA)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "iiisssss",
        $id_usuario,
        $conteudo,
        $nivel,
        $titulo,
        $caminhoCompleto,
        $nomeArquivo,
        $data,
        $status
    );

    if ($stmt->execute()) {

        echo "OK!";

    } else {

        echo "erro_banco";
    }

    $stmt->close();

} else {

    echo "erro_upload";
}

?>