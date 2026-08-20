<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Materiais</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/navbar.css">

</head>

<body>


    <main class="container">

        <h1>Criar material</h1>

        <p class="subtitulo">
            Adicione um novo material ao SIRIUS.
        </p>


        <form action="../php/cadastrarMaterial.php"
              method="POST"
              id="criaMaterial"
              enctype="multipart/form-data">


            <div class="campo">

                <label for="titulo">
                    Título do material
                </label>

                <input type="text" id="titulo" name="titulo" placeholder="Digite o título do material" required>

            </div>

            <div class="campo">

                <label for="disciplina">
                    Disciplina
                </label>

                <div class="campo-busca">

                    <input
                        type="text" id="disciplina" name="disciplina" placeholder="Digite para pesquisar..." autocomplete="off" required>

                    <input
                        type="hidden" id="id_disciplina"  name="id_disciplina"
                    >

                    <div
                        id="resultadoDisciplinas"
                        class="resultados">
                    </div>

                </div>

                <button
                    type="button"
                    class="criar-link"
                    id="abrirDisciplina">

                    Não encontrou a disciplina? Criar uma

                </button>

            </div>

            <div class="campo">

                <label for="conteudo">
                    Conteúdo
                </label>

                <div class="campo-busca">

                    <input
                        type="text"
                        id="conteudo"
                        name="conteudo"
                        placeholder="Digite para pesquisar..."
                        autocomplete="off"
                        required
                    >

                    <input
                        type="hidden"
                        id="id_conteudo"
                        name="id_conteudo"
                    >

                    <div
                        id="resultadoConteudos"
                        class="resultados">
                    </div>

                </div>

                <button
                    type="button"
                    class="criar-link"
                    id="abrirConteudo">

                    Não encontrou o conteúdo? Criar um

                </button>

            </div>


            <div class="campo">

                <label for="nivel">
                    Nível de ensino
                </label>

                <select
                    id="nivel"
                    name="nivel"
                    required>

                    <option value="">
                        Selecione...
                    </option>

                    <option value="1">
                        Ens. Fundamental I
                    </option>

                    <option value="2">
                        Ens. Fundamental II
                    </option>

                    <option value="3">
                        Ens. Médio
                    </option>

                    <option value="4">
                        Ens. Superior
                    </option>

                </select>

            </div>


            <div class="campo">

                <label for="arquivo">
                    Arquivo
                </label>

                <input
                    type="file"
                    id="arquivo"
                    name="arquivo"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-cadastrar">

                Cadastrar material

            </button>

        </form>

    </main>

    <dialog
        class="modal"
        id="modalDisciplina">

        <div class="modal-conteudo">

            <button
                type="button"
                class="fechar"
                id="fecharDisciplina">

                <i class="bx bx-x"></i>

            </button>


            <h2>
                Criar disciplina
            </h2>


            <form id="formDisciplina">

                <label for="novaDisciplina">
                    Nome da disciplina
                </label>

                <input
                    type="text"
                    id="novaDisciplina"
                    name="nome"
                    placeholder="Ex: História"
                    required
                >


                <button type="submit">

                    Criar disciplina

                </button>

            </form>

        </div>

    </dialog>


    <dialog
        class="modal"
        id="modalConteudo">

        <div class="modal-conteudo">

            <button
                type="button"
                class="fechar"
                id="fecharConteudo">

                <i class="bx bx-x"></i>

            </button>


            <h2>
                Criar conteúdo
            </h2>


            <form id="formConteudo">

                <label for="novoConteudo">
                    Nome do conteúdo
                </label>

                <input
                    type="text"
                    id="novoConteudo"
                    name="nome"
                    placeholder="Ex: Primeira Guerra Mundial"
                    required
                >


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
            <li>
                <a href="criar.php">
                    <i class="bx bx-plus"></i>
                    <span class="tooltip">Criar</span>
                </a>
            </li>
            <li>
                <a href="/pesquisar.php">
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
            <li class="active">
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

</body>

</html>