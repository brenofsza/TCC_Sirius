<?php
session_start();
include("conexao.php");

$id_usuario = $_POST['id_usuario'] ?? '';


if($id_usuario == ''){

	echo "ERRO";

	exit;
}


//conexoes que o usu fez

$sql = "SELECT U.ID_USU, U.NOME_USU, U.USERNAME, U.FOTO_USU
		FROM LIGACAO L
		INNER JOIN USUARIO U
		ON U.ID_USU = L.COD_USU_DESTINO
		WHERE L.COD_USU = ?
		AND L.STATUS_LIGACAO = 'ACEITA'";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


while($usuario = $resultado->fetch_assoc()){

	if(empty($usuario['FOTO_USU'])){

		$foto = "../img/user.webp";

	} else {

		$foto = "../" . $usuario['FOTO_USU'];

	}


        echo "
            <a href='../front/perfilUsuario.php?id=" . $usuario['ID_USU'] . "' class='item-conexao'>

                <img src='" . htmlspecialchars($foto) . "' alt='Foto de perfil'>

                <div>
                    <strong>" . htmlspecialchars($usuario['NOME_USU']) . "</strong>
                    <p>@" . htmlspecialchars($usuario['USERNAME']) . "</p>
                </div>

            </a>
        ";



}


$stmt->close();


// conexoes que o usu recebeu

$sql = "SELECT U.ID_USU, U.NOME_USU, U.USERNAME, U.FOTO_USU
		FROM LIGACAO L
		INNER JOIN USUARIO U
		ON U.ID_USU = L.COD_USU
		WHERE L.COD_USU_DESTINO = ?
		AND L.STATUS_LIGACAO = 'ACEITA'";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


while($usuario = $resultado->fetch_assoc()){

	if(empty($usuario['FOTO_USU'])){

		$foto = "../img/user.webp";

	} else {

		$foto = "../" . $usuario['FOTO_USU'];

	}


	
        echo "
            <a href='../front/perfilUsuario.php?id=" . $usuario['ID_USU'] . "' class='item-conexao'>

                <img src='" . htmlspecialchars($foto) . "' alt='Foto de perfil'>

                <div>
                    <strong>" . htmlspecialchars($usuario['NOME_USU']) . "</strong>
                    <p>@" . htmlspecialchars($usuario['USERNAME']) . "</p>
                </div>

            </a>
        ";



}


$stmt->close();

?>