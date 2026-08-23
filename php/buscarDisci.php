<?php

include("conexao.php");

$nome = $_POST["nome"];

$sql = "SELECT * FROM DISCIPLINA 
        WHERE NOME_DISCI LIKE ? 
        ORDER BY NOME_DISCI";

$stmt = $conexao->prepare($sql);

$busca = "%" . $nome . "%";

$stmt->bind_param("s", $busca);

$stmt->execute();

$resultado = $stmt->get_result();

$disciplinas = [];

while($linha = $resultado->fetch_assoc()){

    $disciplinas[] = [
        "id" => $linha["ID_DISCI"],
        "nome" => $linha["NOME_DISCI"]
    ];

}

echo json_encode($disciplinas);

?>