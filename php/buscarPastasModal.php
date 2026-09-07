<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    exit;

}


$id_usuario = $_SESSION['id_usuario'];


$sql = "SELECT *
        FROM PASTA
        WHERE COD_USU = ?
        ORDER BY ID_PASTA ASC";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

    while($pasta = $resultado->fetch_assoc()){

        echo "<button type='button' class='pastaSalvar' data-id='" . $pasta['ID_PASTA'] . "'>";

        echo "<i class='bx bx-folder'></i>";

        echo htmlspecialchars($pasta['NOME_PASTA']);

        echo "</button>";

    }

} else {

    echo "<p>Nenhuma pasta encontrada.</p>";

}


$stmt->close();

?>