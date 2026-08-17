<?php
session_start(); 
include("conexao.php");


$id_usuario = $_SESSION['id_usuario'];

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    echo "erro_arquivo";
    exit;
}

$arquivo = $_FILES['foto'];

$tamMax = 2 * 1024 * 1024;
$extPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

$extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

if ($arquivo['size'] > $tamMax) {
    echo "erro_tamanho";
    exit;
}

if (!in_array($extensao, $extPermitidas)) {
    echo "erro_extensao";
    exit;
}

$pastaUpload = "uploads/fotos_usu/";



$sql1 = "SELECT FOTO_USU FROM USUARIO WHERE ID_USU = ?";
$stmt1 = $conexao->prepare($sql1);
$stmt1->bind_param("i", $id_usuario);
$stmt1->execute();
$resultado = $stmt1->get_result();

if ($dados = $resultado->fetch_assoc()) {
    $fotoAntiga = $dados['FOTO_USU'];
    $caminhoAntigo = "../" . $fotoAntiga;

    
    if (!empty($fotoAntiga) && file_exists($caminhoAntigo)) {
        unlink($caminhoAntigo); 
    }
}
$stmt1->close();


$nvNome = uniqid("usu_", true) . "." . $extensao;
$caminhoCompleto = $pastaUpload . $nvNome;

if (move_uploaded_file($arquivo['tmp_name'], "../".$caminhoCompleto)) {
    
    $sql = "UPDATE USUARIO SET FOTO_USU = ? WHERE ID_USU = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $caminhoCompleto, $id_usuario);

    if ($stmt->execute()) {
        echo $caminhoCompleto; 
        $_SESSION['foto_usuario'] = $caminhoCompleto;
    } else {
        echo "erro_banco";
    }
    
    $stmt->close();

} else {
    echo "erro_upload"; 
}
?>
