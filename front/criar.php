<?php 
session_start(); 
include '../php/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: logar.php");
    exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Materiais</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/typeahead.css">
</head>

<body>

    <main class="container">
        <h1>Criar material</h1>

        <p class="subtitulo">
            Adicione um novo material ao SIRIUS.
        </p>

       
        <div id="mensagem" style="display: none;"></div>

        <form action="../php/cadMaterial.php" method="POST" id="criaMaterial" enctype="multipart/form-data">

            <div class="campo">
                <label for="titulo">Título do material</label>

                <input type="text" id="titulo" name="titulo"
                    placeholder="Digite o título do material" required>
            </div>

            <div class="campo">
                <label for="disci">Disciplina</label>

                <div class="campo-busca">
                    <input type="text" id="disci" name="disci"
                        placeholder="Digite para pesquisar..."
                        autocomplete="off" required>

                    <input type="hidden" id="id_disci" name="id_disci">
                </div>

                <button type="button" class="criar-link" id="abrirDisci">
                    Não encontrou a disciplina? Criar uma
                </button>
            </div>

            <div class="campo">
                <label for="cont">Conteúdo</label>

                <div class="campo-busca">
                    <input type="text" id="cont" name="cont"
                        placeholder="Digite para pesquisar..."
                        autocomplete="off" required>

                    <input type="hidden" id="id_cont" name="id_cont">
                </div>

                <button type="button" class="criar-link" id="abrirCont">
                    Não encontrou o conteúdo? Criar um
                </button>
            </div>

            <div class="campo">
                <label for="nivel">Nível de ensino</label>

                <select id="nivel" name="nivel" required>
                    <option value="">Selecione...</option>
                    <option value="1">Ens. Fundamental I</option>
                    <option value="2">Ens. Fundamental II</option>
                    <option value="3">Ens. Médio</option>
                    <option value="4">Ens. Superior</option>
                </select>
            </div>

            <div class="campo">
                <label for="arquivo">Arquivo</label>
                <input type="file" id="arquivo" name="arquivo" required>
            </div>        

                <div class="campo">
                    <label>Status do material</label>

                    <label>
                        <input type="radio" name="status" value="PUBLICO">
                        Público
                    </label>

                    <label>
                        <input type="radio" name="status" value="PRIVADO">
                        Privado
                    </label>
                </div>

                <div class="campo">
                    <label for="descricao">Descrição</label>

                    <textarea id="descricao" name="descricao"
                        placeholder="Descreva brevemente o conteúdo do material..."
                        maxlength="500" rows="3"></textarea>
                </div>

            <button type="submit" class="btn-cadastrar">
                Cadastrar material
            </button>

        </form>
    </main>

    <dialog class="modal" id="modalDisci">
        <div class="modal-conteudo">

            <button type="button" class="fechar" id="fecharDisci">
                <i class="bx bx-x"></i>
            </button>

            <h2>Criar disciplina</h2>

            <form id="formDisci">
                <label for="novaDisci">Nome da disciplina</label>
                <input type="text" id="novaDisci" name="nome" placeholder="Ex: História" required>

                <button type="submit">
                    Criar disciplina
                </button>
            </form>

        </div>
    </dialog>

    <dialog class="modal" id="modalCont">
        <div class="modal-conteudo">

            <button type="button" class="fechar" id="fecharCont">
                <i class="bx bx-x"></i>
            </button>

            <h2>Criar conteúdo</h2>

            <form id="formCont">
                <label for="novoCont">Nome do conteúdo</label>
                <input type="text" id="novoCont" name="nome" placeholder="Ex: Primeira Guerra Mundial" required>

                <button type="submit">
                    Criar conteúdo
                </button>
            </form>

        </div>
    </dialog>

    <nav class="sidebar-navigation">
        <ul>
            <li>
                <a href="../index.php">
                    <i class="bx bx-home-alt"></i>
                    <span class="tooltip">Inicio</span>
                </a>
            </li>

            <li class="active">
                <a href="criar.php">
                    <i class="bx bx-plus"></i>
                    <span class="tooltip">Criar</span>
                </a>
            </li>

            <li>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/navbar.js"></script>
    <script src="../js/criar.js"></script>
    <script src="../js/bootstrap3-typeahead.js"></script>

</body>

</html>