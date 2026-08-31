<?php
session_start();
include("conexao.php");


$id_usuario = $_SESSION['id_usuario'];
$id_ligacao = $_POST['id_ligacao'] ?? '';
$acao = $_POST['acao'] ?? '';


if($id_ligacao == '' || $acao == ''){
	echo "ERRO";
	exit;
}

// verifica se a solicitacao pertence ao usuario logado
$sql = "SELECT ID_LIGACAO
		FROM LIGACAO
		WHERE ID_LIGACAO = ?
		AND COD_USU_DESTINO = ?
		AND STATUS_LIGACAO = 'PENDENTE'";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
	"ii",
	$id_ligacao,
	$id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();

$stmt->close();


if($resultado->num_rows == 0){

	echo "ERRO";

	exit;
}


// aceita a solicitacao
if($acao == "aceitar"){

	$sql = "UPDATE LIGACAO
			SET STATUS_LIGACAO = 'ACEITA'
			WHERE ID_LIGACAO = ?";

	$stmt = $conexao->prepare($sql);

	$stmt->bind_param(
		"i",
		$id_ligacao
	);

	if($stmt->execute()){

		echo "ACEITA";

	} else {

		echo "ERRO";

	}

	$stmt->close();


// recusa a solicitacao
} else if($acao == "recusar"){

	$sql = "DELETE FROM LIGACAO
			WHERE ID_LIGACAO = ?";

	$stmt = $conexao->prepare($sql);

	$stmt->bind_param(
		"i",
		$id_ligacao
	);

	if($stmt->execute()){

		echo "RECUSADA";

	} else {

		echo "ERRO";

	}

	$stmt->close();

}

?>