<?php session_start(); ?>
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

	<div class="logo">
        <img src="img/logo.png">
    </div>	

  <nav class="sidebar-navigation">

  <ul>
		<li class="active">
			<a href="index.php">
				<i class="bx bx-home-alt"></i>
				<span class="tooltip">Inicio</span>
			</a>
		</li>

		<li>
			<a href="front/criar.php">
				<i class="bx bx-plus"></i>
				<span class="tooltip">Criar</span>
			</a>
		</li>

		<li>
			<a href="front/pesquisar.php">
				<i class="bx bx-search-alt"></i>
				<span class="tooltip">Pesquisar</span>
			</a>
		</li>

		<li>
			<a href="front/planejamento.php">
				<i class="bx bx-calendar-event"></i>
				<span class="tooltip">Planejamento</span>
			</a>
		</li>

		<li>
			<a href="front/perfil.php">
				<i class="bx bx-user"></i>
				<span class="tooltip">Perfil</span>
			</a>
		</li>
	</ul>
</nav>

	<form action="/pesquisa" method="get">
  		<input type="search" name="q" placeholder="Buscar usuários, conteúdos ou materiais..." required>
  			<button type="submit">Buscar</button>
		</form>

		<div>
			<h3>Explore novas possibilidades para suas aulas.</h3>
			<h1>Organize seu conhecimento de forma inteligente.</h1>
			<h3>Crie, organize e compartilhe questões e materiais em um só lugar.
			Sirius conecta você a conteúdos de outros professores.</h3>
		</div>

<?php
if(empty($_SESSION['nome'])){
	$foto = '../img/user.webp';	
	echo "<img src='$foto'>";
	echo "<a href='front/logar.php'>Entrar</a>";
	
}else{
	if (empty($_SESSION['foto_usuario'])) { 
		$foto = 'img/user.webp'; 
	} else { 
		$foto = $_SESSION['foto_usuario']; 
	}
	echo "<p>Olá, " . $_SESSION['nome'] . "!</p><img src='$foto' class='fotoPerfil'>";
}
?>

<script src="js/navbar.js"></script>
</body>
</html>