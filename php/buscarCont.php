<?php

include("conexao.php");

$nome = $_POST["nome"];
$disci = $_POST["disci"];

$sql = "SELECT * FROM CONTEUDO
        WHERE NOME_CONTEUDO LIKE ?
        AND COD_DISCI = ?
        ORDER BY NOME_CONTEUDO";

$stmt = $conexao->prepare($sql);

$busca = "%" . $nome . "%";

$stmt->bind_param("si", $busca, $disci);

$stmt->execute();

$resultado = $stmt->get_result();

$conteudos = [];

while($linha = $resultado->fetch_assoc()){

    $conteudos[] = [
        "id" => $linha["ID_CONTEUDO"],
        "nome" => $linha["NOME_CONTEUDO"]
    ];

}

echo json_encode($conteudos);

?>