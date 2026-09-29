<?php 

session_start();
date_default_timezone_set('America/Sao_Paulo');

include '../php/conexao.php';


$id_material = $_GET['id'] ?? '';

if($id_material == ''){
    header("Location: pesquisar.php");
    exit;
}


$sql = "SELECT MATERIAL.*, CONTEUDO.NOME_CONTEUDO, DISCIPLINA.NOME_DISCI,
            NIVEL_ENSINO.NOME_NIVEL, USUARIO.NOME_USU, USUARIO.USERNAME, USUARIO.FOTO_USU
        FROM MATERIAL
        INNER JOIN CONTEUDO ON MATERIAL.COD_CONTEUDO = CONTEUDO.ID_CONTEUDO
        INNER JOIN DISCIPLINA ON CONTEUDO.COD_DISCI = DISCIPLINA.ID_DISCI
        INNER JOIN NIVEL_ENSINO ON MATERIAL.COD_NIVEL = NIVEL_ENSINO.ID_NIVEL
        INNER JOIN USUARIO ON MATERIAL.COD_USU = USUARIO.ID_USU
        WHERE MATERIAL.ID_MATERIAL = ?";


$stmt = $conexao->prepare($sql);

$stmt->bind_param("i", $id_material);

$stmt->execute();

$resultado = $stmt->get_result();


if($resultado->num_rows == 0){
    header("Location: pesquisar.php");
    exit;
}


$material = $resultado->fetch_assoc();

$stmt->close();


$acessoNegado = false;


// verifica quem pode ver o material

if($material['STATUS_MATERIA'] == 'PRIVADO'){

    if(!isset($_SESSION['id_usuario'])){
        header("Location: logar.php");
        exit;
    }

    if($material['COD_USU'] != $_SESSION['id_usuario']){
        header("Location: pesquisar.php");
        exit;
    }

}


if($material['STATUS_MATERIA'] == 'CONEXOES'){

    if(!isset($_SESSION['id_usuario'])){
        header("Location: logar.php");
        exit;
    }

    if($material['COD_USU'] != $_SESSION['id_usuario']){

        $id_usuario = $_SESSION['id_usuario'];

        $sqlLigacao = "SELECT ID_LIGACAO
                       FROM LIGACAO
                       WHERE STATUS_LIGACAO = 'ACEITA'
                       AND (
                           (COD_USU = ? AND COD_USU_DESTINO = ?)
                           OR
                           (COD_USU_DESTINO = ? AND COD_USU = ?)
                       )";

        $stmtLigacao = $conexao->prepare($sqlLigacao);

        $stmtLigacao->bind_param(
            "iiii",
            $id_usuario,
            $material['COD_USU'],
            $id_usuario,
            $material['COD_USU']
        );

        $stmtLigacao->execute();

        $resultadoLigacao = $stmtLigacao->get_result();

        if($resultadoLigacao->num_rows == 0){

            $acessoNegado = true;

        }

        $stmtLigacao->close();

    }

}


// verifica se o material pertence ao usuário logado

$ehDono = false;

if(isset($_SESSION['id_usuario'])){

    if($material['COD_USU'] == $_SESSION['id_usuario']){

        $ehDono = true;

    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/navbar.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../css/typeahead.css">

    <title><?php echo htmlspecialchars($material['TITULO_MATERIA']); ?></title>

    <link rel="icon" type="image/png" href="../img/preBancaTCC.jpg">

</head>


<body>

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


<div class="topbar">

    <div class="logo">

        <img src="../img/logo.png" alt="Logo">

    </div>


    <div class="user">

        <?php

        if(empty($_SESSION['id_usuario'])){

            $foto = '../img/user.webp';

            echo "<a href='logar.php'><img src='$foto' class='fotoPerfil'></a>";

            echo "<a href='logar.php'>Entrar</a>";

        } else {

            if(empty($_SESSION['foto_usuario'])){

                $foto = '../img/user.webp';

            } else {

                $foto = '../' . $_SESSION['foto_usuario'];

            }

            echo "<p>Olá, " . htmlspecialchars($_SESSION['nome']) . "!</p>";

            echo "<a href='perfil.php'><img src='$foto' class='fotoPerfil'></a>";

        }

        ?>

    </div>

</div>


<main class="area-material">


    <a href="javascript:history.back()" class="voltar">

        <i class="bx bx-arrow-back"></i> Voltar

    </a>


    <?php if(!$acessoNegado){ ?>

    <div class="material">


        <h1>

            <?php echo htmlspecialchars($material['TITULO_MATERIA']); ?>

        </h1>


        <p>

            <strong>Disciplina:</strong>

            <?php echo htmlspecialchars($material['NOME_DISCI']); ?>

        </p>


        <p>

            <strong>Conteúdo:</strong>

            <?php echo htmlspecialchars($material['NOME_CONTEUDO']); ?>

        </p>


        <p>

            <strong>Nível:</strong>

            <?php echo htmlspecialchars($material['NOME_NIVEL']); ?>

        </p>


        <?php if(!empty($material['DESCRICAO_MATERIA'])){ ?>

            <p>

                <strong>Descrição:</strong>

                <?php echo htmlspecialchars($material['DESCRICAO_MATERIA']); ?>

            </p>

        <?php } ?>


        <div class="autor-material">

            <?php

            if(empty($material['FOTO_USU'])){

                $fotoAutor = '../img/user.webp';

            } else {

                $fotoAutor = '../' . $material['FOTO_USU'];

            }

            ?>


            <a href="perfilUsuario.php?id=<?php echo $material['COD_USU']; ?>">

                <img 
                    src="<?php echo htmlspecialchars($fotoAutor); ?>" 
                    class="fotoPerfil"
                >


                <div>

                    <p>Publicado por:</p>

                    <p>

                        <?php echo htmlspecialchars($material['NOME_USU']); ?>

                        (@<?php echo htmlspecialchars($material['USERNAME']); ?>)

                    </p>

                </div>

            </a>

        </div>


        <p>

            <strong>Data:</strong>

            <?php echo date("d/m/Y", strtotime($material['DATA_CAD'])); ?>

        </p>


        <p>

            <strong>Arquivo:</strong>

            <?php echo htmlspecialchars($material['NOME_ARQUIVO']); ?>

        </p>


        <a 
            href="../<?php echo htmlspecialchars($material['CAMINHO_ARQUIVO']); ?>" 
            target="_blank"
        >

            Abrir arquivo

        </a>


        <a 
            href="../<?php echo htmlspecialchars($material['CAMINHO_ARQUIVO']); ?>" 
            download="<?php echo htmlspecialchars($material['NOME_ARQUIVO']); ?>"
        >

            Baixar arquivo

        </a>


        <?php if(isset($_SESSION['id_usuario'])){ ?>

            <button 
                type="button" 
                id="salvarMaterial"
                data-id="<?php echo $material['ID_MATERIAL']; ?>"
            >

                <i class="bx bx-bookmark"></i>

                Salvar material

            </button>

        <?php } ?>


        <?php if($ehDono){ ?>

            <button 
                type="button" 
                id="editarMaterial"
                data-id="<?php echo $material['ID_MATERIAL']; ?>"
            >

                Editar material

            </button>


            <button
                type="button"
                id="excluirMaterial"
                data-id="<?php echo $material['ID_MATERIAL']; ?>"
            >

                Excluir material

            </button>

        <?php } ?>


    </div>

    <?php } ?>


</main>


<?php if($acessoNegado){ ?>

<dialog id="modalAcessoNegado">

    <div class="modal-acesso-negado">

        <button type="button" id="fecharAcessoNegado">

            <i class="bx bx-x"></i>

        </button>


        <h2>Material indisponível</h2>


        <p>

            Este material está disponível somente para conexões do autor.

        </p>


        <button 
            type="button" 
            id="solicitarConexao"
            data-id="<?php echo $material['COD_USU']; ?>"
        >

            Solicitar conexão

        </button>

    </div>

</dialog>

<?php } ?>


<dialog id="modalSalvarMaterial">

    <div class="modal-salvar-material">

        <button type="button" id="fecharSalvarMaterial">

            <i class="bx bx-x"></i>

        </button>


        <h2>Salvar material</h2>


        <p>Escolha uma pasta:</p>


        <div id="pastasSalvar">

            <p>Carregando pastas...</p>

        </div>


    </div>

</dialog>


<?php if($ehDono){ ?>

<dialog id="modalExcluirMaterial">

    <div class="modal-excluir-material">

        <button type="button" id="fecharExcluirMaterial">

            <i class="bx bx-x"></i>

        </button>


        <h2>Excluir material</h2>


        <p>

            Tem certeza que deseja excluir este material?

        </p>


        <p>

            Essa ação não poderá ser desfeita.

        </p>


        <button
            type="button"
            id="confirmarExcluirMaterial"
        >

            Excluir material

        </button>


        <button
            type="button"
            id="cancelarExcluirMaterial"
        >

            Cancelar

        </button>


        <div id="mensagemExcluirMaterial"></div>

    </div>

</dialog>


<dialog id="modalEditarMaterial">

    <div class="modal-editar-material">

        <button type="button" id="fecharEditarMaterial">

            <i class="bx bx-x"></i>

        </button>


        <h2>Editar material</h2>


        <form id="formEditarMaterial">

            <input
                type="hidden"
                id="editarIdMaterial"
            >


            <div class="campo">

                <label for="editarTitulo">
                    Título
                </label>

                <input
                    type="text"
                    id="editarTitulo"
                    maxlength="100"
                    required
                >

            </div>


            <div class="campo">

                <label for="editarDisci">
                    Disciplina
                </label>

                <input
                    type="text"
                    id="editarDisci"
                    autocomplete="off"
                    required
                >

                <input
                    type="hidden"
                    id="editarIdDisci"
                >

                <button
                    type="button"
                    class="criar-link"
                    id="abrirEditarDisci"
                >
                    Não encontrou a disciplina? Criar uma
                </button>

            </div>


            <div class="campo">

                <label for="editarCont">
                    Conteúdo
                </label>

                <input
                    type="text"
                    id="editarCont"
                    autocomplete="off"
                    required
                >

                <input
                    type="hidden"
                    id="editarIdCont"
                >

                <button
                    type="button"
                    class="criar-link"
                    id="abrirEditarCont"
                >
                    Não encontrou o conteúdo? Criar um
                </button>

            </div>


            <div class="campo">

                <label for="editarNivel">
                    Nível de ensino
                </label>

                <select
                    id="editarNivel"
                    required
                >

                    <option value="">
                        Selecione
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

                <label>
                    Status do material
                </label>

                <label>

                    <input
                        type="radio"
                        name="editarStatus"
                        value="PUBLICO"
                    >

                    Público

                </label>


                <label>

                    <input
                        type="radio"
                        name="editarStatus"
                        value="PRIVADO"
                    >

                    Privado

                </label>


                <label>

                    <input
                        type="radio"
                        name="editarStatus"
                        value="CONEXOES"
                    >

                    Somente conexões

                </label>

            </div>


            <div class="campo">

                <label for="editarDescricao">
                    Descrição
                </label>

                <textarea
                    id="editarDescricao"
                    maxlength="300"
                ></textarea>

            </div>


            <div class="campo">

                <label>Arquivo atual</label>

                <p id="arquivoAtual">
                    <?php echo htmlspecialchars($material['NOME_ARQUIVO']); ?>
                </p>

                <label for="editarArquivo">
                    Escolher novo arquivo
                </label>

                <input
                    type="file"
                    id="editarArquivo"
                    accept=".pdf,.jpg,.jpeg,.png,.webp,.ppt,.pptx"
                >

                <p>
                    Se não escolher um novo arquivo, o arquivo atual será mantido.
                </p>

            </div>


            <button type="submit">
                Salvar alterações
            </button>


            <button
                type="button"
                id="cancelarEditarMaterial"
            >
                Cancelar
            </button>


            <div id="mensagemEditarMaterial"></div>

        </form>

    </div>

</dialog>


<dialog class="modal" id="modalEditarDisci">

    <div class="modal-conteudo">

        <button
            type="button"
            class="fechar"
            id="fecharEditarDisci"
        >

            <i class="bx bx-x"></i>

        </button>


        <h2>Criar disciplina</h2>


        <form id="formEditarDisci">

            <label for="novaEditarDisci">
                Nome da disciplina
            </label>


            <input
                type="text"
                id="novaEditarDisci"
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


<dialog class="modal" id="modalEditarCont">

    <div class="modal-conteudo">

        <button
            type="button"
            class="fechar"
            id="fecharEditarCont"
        >

            <i class="bx bx-x"></i>

        </button>


        <h2>Criar conteúdo</h2>


        <form id="formEditarCont">

            <label for="novoEditarCont">
                Nome do conteúdo
            </label>


            <input
                type="text"
                id="novoEditarCont"
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

<?php } ?>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="../js/bootstrap3-typeahead.js"></script>

<script src="../js/material.js"></script>


</body>

</html>