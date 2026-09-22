<?php

session_start();

include("conexao.php");


if(!isset($_SESSION['id_usuario'])){

    echo "<p>Faça login para visualizar suas pastas.</p>";

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

        echo "<a href='../front/pastaSalva.php?id=" . $pasta['ID_PASTA'] . "' class='card-pasta'>";

        echo "<i class='bx bx-folder'></i>";

        echo "<p>" . htmlspecialchars($pasta['NOME_PASTA']) . "</p>";

        echo "</a>";

    }

} else {

    // Este bloco substitui os cartões quando o usuário ainda não possui pastas.
    echo "<div class='estado-vazio-pastas'>";
    echo "<i class='bx bx-folder-open' aria-hidden='true'></i>";
    echo "<h2>Suas pastas aparecem aqui</h2>";
    echo "<p>Crie uma pasta para começar a organizar seus materiais salvos.</p>";
    echo "</div>";

}


$stmt->close();

?>
