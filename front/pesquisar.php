<?php 
session_start(); 
include '../php/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: logar.php");
    exit;
}

$pesquisa = $_GET['q'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesquisar</title>

    <link rel="icon" type="image/png" href="../img/preBancaTCC.jpg">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/typeahead.css">
    <link rel="stylesheet" href="../css/pesquisar.css">
</head>

<body>

    <div class="topbar">

        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>

        <form class="search-bar" id="formPesquisa">

            <input type="search" id="pesquisa" name="q" placeholder="Buscar materiais ou usuários..." value="<?php echo htmlspecialchars($pesquisa); ?>" required>

            <button type="submit">
                Buscar
            </button>

        </form>

    </div>


    <nav class="sidebar-navigation">

        <ul>

            <li>
                <a href="../index.php">
                    <i class="bx bx-home-alt"></i>
                    <span class="tooltip">Inicio</span>
                </a>
            </li>

            <li>
                <a href="criar.php">
                    <i class="bx bx-plus"></i>
                    <span class="tooltip">Criar</span>
                </a>
            </li>

            <li class="active">
                <a href="pesquisar.php">
                    <i class="bx bx-search-alt"></i>
                    <span class="tooltip">Pesquisar</span>
                </a>
            </li>

            <li>
                <a href="planejamento.php">
                    <i class="bx bx-calendar-event"></i>
                    <span class="tooltip">Planejamento</span>
                </a>
            </li>

            <li>
                <a href="perfil.php">
                    <i class="bx bx-user"></i>
                    <span class="tooltip">Perfil</span>
                </a>
            </li>
        </ul>

    </nav>


    <main class="area-pesquisa">

        <div class="tipos-pesquisa">

            <button class="tipoPesquisa ativo" data-tipo="materiais">
                Materiais
            </button>

            <button class="tipoPesquisa" data-tipo="usuarios">
                Usuários
            </button>

        </div>


        <div id="filtros">

            <div class="filtro">
                <label for="filtroDisci">Disciplina</label>
                <select id="filtroDisci">
                    <option value="">Todas as disciplinas</option>
                </select>
            </div>

            <div class="filtro">
                <label for="filtroCont">Conteúdo</label>
                <select id="filtroCont" disabled>
                    <option value="">Todos os conteúdos</option>
                </select>
            </div>

        </div>


        <div id="resultadoPesquisa">

           

        </div>

    </main>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/navbar.js"></script>
    <script src="../js/pesquisar.js"></script>

</body>

</html>