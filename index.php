<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial</title>

 <link rel="stylesheet" href="css/navbar.css">
 <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
	<?php session_start(); ?>

	<div class="logo">
        <img src="img/logo.png">
    </div>	

	<form action="/pesquisa" method="get">
  		<input type="search" name="q" placeholder="Pesquisar..." required>
  			<button type="submit">Buscar</button>
		</form>

	
<?php
if(empty($_SESSION['nome'])){
	echo "<a href='front/logar.php'>Entrar</a>";
}else{
	echo "<p>Olá, " . $_SESSION['nome'] . "!";
	echo "<a href='php/logout.php'>Sair</a>";

}
?>




<script src="js/navbar.js"></script>
</body>
</html>