<?php
include "conexao.php";

$id = $_GET['id'];

mysqli_query($conexao, "DELETE FROM USUARIO WHERE ID_USU=$id");

?>