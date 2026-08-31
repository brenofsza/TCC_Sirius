<?php
session_start();

include("conexao.php");


$id_usuario = $_SESSION['id_usuario'];


// busca as solicitacoes recebidas
$sql = "SELECT LIGACAO.ID_LIGACAO,
			   USUARIO.ID_USU,
			   USUARIO.NOME_USU,
			   USUARIO.USERNAME,
			   USUARIO.FOTO_USU
		FROM LIGACAO
		INNER JOIN USUARIO ON LIGACAO.COD_USU = USUARIO.ID_USU
		WHERE LIGACAO.COD_USU_DESTINO = ?
		AND LIGACAO.STATUS_LIGACAO = 'PENDENTE'
		ORDER BY USUARIO.NOME_USU";


$stmt = $conexao->prepare($sql);

$stmt->bind_param(
	"i",
	$id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows > 0){

	while($solicitacao = $resultado->fetch_assoc()){

		if(empty($solicitacao['FOTO_USU'])){

			$foto = "img/user.webp";

		} else {

			$foto =  $solicitacao['FOTO_USU'];

		}


		echo "<div class='solicitacao'>";

		echo "<img src='" . htmlspecialchars($foto) . "' class='foto-usuario'>";

		echo "<div class='info-solicitacao'>";

		echo "<h3>" . 
			htmlspecialchars($solicitacao['NOME_USU']) . 
		"</h3>";

		echo "<p>@" . 
			htmlspecialchars($solicitacao['USERNAME']) . 
		"</p>";

		echo "<button class='aceitarConexao' data-id='" . 
			$solicitacao['ID_LIGACAO'] . 
			"'>Aceitar</button>";

		echo "<button class='recusarConexao' data-id='" . 
			$solicitacao['ID_LIGACAO'] . 
			"'>Recusar</button>";

		echo "</div>";

		echo "</div>";

	}

} else {

	echo "<p>Nenhuma solicitação de conexão.</p>";

}


$stmt->close();

?>