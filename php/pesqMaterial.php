<?php

session_start();

include("conexao.php");


$pesquisa = trim($_POST['pesquisa'] ?? '');

$tipo = $_POST['tipo'] ?? 'materiais';


if($pesquisa == ''){

	echo "<p>Digite algo para pesquisar.</p>";

	exit;
}


$busca = "%" . $pesquisa . "%";

// pesquia materiaiss
if($tipo == "materiais"){

	$sql = "SELECT  MATERIAL.*, CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI,
				NIVEL_ENSINO.NOME_NIVEL, USUARIO.NOME_USU, USUARIO.USERNAME, USUARIO.FOTO_USU
			FROM MATERIAL
			INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
            INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
            INNER JOIN NIVEL_ENSINO ON MATERIAL.COD_NIVEL = NIVEL_ENSINO.ID_NIVEL
			INNER JOIN USUARIO ON MATERIAL.COD_USU = USUARIO.ID_USU		
			WHERE
				MATERIAL.TITULO_MATERIA LIKE ?
				OR MATERIAL.DESCRICAO_MATERIA LIKE ?
				OR CONTEUDO.NOME_CONTEUDO LIKE ?
				OR DISCIPLINA.NOME_DISCI LIKE ?
			ORDER BY MATERIAL.DATA_CAD DESC";


	$stmt = $conexao->prepare($sql);

	$stmt->bind_param(
		"ssss",
		$busca,
		$busca,
		$busca,
		$busca
	);

	$stmt->execute();

	$resultado = $stmt->get_result();


	if($resultado->num_rows > 0){

		while($material = $resultado->fetch_assoc()){

			echo "<div class='card-material'>";

			echo "<h3>" . 
				htmlspecialchars($material['TITULO_MATERIA']) . 
			"</h3>";

			echo "<p>" . 
				htmlspecialchars($material['NOME_DISCI']) . 
				" • " . 
				htmlspecialchars($material['NOME_CONTEUDO']) . 
			"</p>";

			echo "<p>" . 
				htmlspecialchars($material['NOME_NIVEL']) . 
			"</p>";

			if(!empty($material['DESCRICAO_MATERIA'])){

				echo "<p>" . 
					htmlspecialchars($material['DESCRICAO_MATERIA']) . 
				"</p>";

			}

			echo "</div>";

		}

	} else {

		echo "<p>Nenhum material encontrado.</p>";

	}

	$stmt->close();

//Pesquisa os usuarioss
} else if($tipo == "usuarios"){

	$sql = "SELECT  ID_USU, NOME_USU, USERNAME, DESCRICAO_USU, FOTO_USU
			FROM USUARIO
			WHERE NOME_USU LIKE ? OR USERNAME LIKE ?
			ORDER BY NOME_USU";

	$stmt = $conexao->prepare($sql);
	$stmt->bind_param(
		"ss",
		$busca,
		$busca
	);

	$stmt->execute();
	$resultado = $stmt->get_result();


	if($resultado->num_rows > 0){

		while($usuario = $resultado->fetch_assoc()){

			if(empty($usuario['FOTO_USU'])){

				$foto = "../img/user.webp";

			} else {

				$foto = "../" . $usuario['FOTO_USU'];

			}


			echo "<div class='card-usuario'>";
			echo "<img src='" . htmlspecialchars($foto) . "' class='foto-usuario'>";
			echo "<div class='info-usuario'>";
			echo "<h3>" . htmlspecialchars($usuario['NOME_USU']) . "</h3>";
			

			echo "<p>@" . htmlspecialchars($usuario['USERNAME']) . "</p>";
			

			if(!empty($usuario['DESCRICAO_USU'])){

				echo "<p>" . htmlspecialchars($usuario['DESCRICAO_USU'])."</p>";
			}

			echo "</div>
                    </div>";}
        } else {
		echo "<p>Nenhum usuário encontrado.</p>";
	}
	
	$stmt->close();

}

?>