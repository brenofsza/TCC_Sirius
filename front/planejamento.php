<?php

session_start();

include '../php/conexao.php';


if(!isset($_SESSION['id_usuario'])){

    header("Location: logar.php");

    exit;

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/planejamento.css">

    <link rel="stylesheet" href="../css/navbar.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Planejamento</title>

</head>

<body>

    <main class="container">

        <div class="cabecalho-planejamento">

            <div>

                <h1>Planejamento de aulas</h1>

                <p class="subtitulo">
                    Organize suas aulas e acompanhe seu planejamento.
                </p>

            </div>

            <button type="button" id="novaAula">
                <i class='bx bx-plus'></i>
                Nova aula
            </button>

        </div>


        <div class="conteudo-planejamento">

            <section class="calendario">

                <div class="cabecalho-calendario">

                    <button type="button" id="mesAnterior">
                        <i class='bx bx-chevron-left'></i>
                    </button>

                    <h2 id="mesAno"></h2>

                    <button type="button" id="proximoMes">
                        <i class='bx bx-chevron-right'></i>
                    </button>

                </div>


                <div class="dias-semana">

                    <span>Dom</span>
                    <span>Seg</span>
                    <span>Ter</span>
                    <span>Qua</span>
                    <span>Qui</span>
                    <span>Sex</span>
                    <span>Sáb</span>

                </div>


                <div class="dias-calendario" id="diasCalendario">

                </div>

            </section>


            <section class="proximas-aulas">

                <h2>Próximas aulas</h2>

                <div id="listaProximasAulas">

                    <p>Nenhuma próxima aula.</p>

                </div>

            </section>

        </div>


        <section class="aulas-dia">

            <div class="cabecalho-aulas">

                <h2 id="tituloAulasDia">
                    Aulas do dia
                </h2>

            </div>

            <div id="listaAulasDia">

                <p>Selecione um dia no calendário.</p>

            </div>

        </section>

    </main>


    <dialog class="modal" id="modalAula">

        <div class="modal-conteudo">

            <button type="button" class="fechar" id="fecharAula">
                <i class="bx bx-x"></i>
            </button>

            <div id="mensagemAula"></div>

            <h2>Nova aula</h2>

            <form id="formAula">

                <div class="campo">

                    <label for="tituloAula">Título da aula</label>

                    <input type="text" id="tituloAula" name="titulo"
                        placeholder="Digite o título da aula" required>

                </div>


                <div class="campo">

                    <label for="assuntoAula">Assunto</label>

                    <textarea id="assuntoAula" name="assunto"
                        placeholder="Descreva o assunto da aula..."
                        rows="3"></textarea>

                </div>


                <div class="campo">

                    <label for="dataAula">Data</label>

                    <input type="date" id="dataAula" name="data" required>

                </div>


                <div class="campo">

                    <label for="horaInicio">Hora de início</label>

                    <input type="time" id="horaInicio" name="hora_inicio" required>

                </div>


                <div class="campo">

                    <label for="horaFim">Hora de término</label>

                    <input type="time" id="horaFim" name="hora_fim" required>

                </div>


                <div class="campo">

                    <label for="sala">Sala / Turma</label>

                    <input type="text" id="sala" name="sala"
                        placeholder="Ex: 3ª A Etec Phila" required>

                </div>


                <div class="campo">

                    <label for="pesquisaMaterial">Materiais da aula</label>

                    <input type="text" id="pesquisaMaterial"
                        placeholder="Pesquise um material...">

                    <div id="resultadoMateriais"></div>

                    <button type="button" id="abrirMateriaisSalvos">
                        <i class="bx bx-folder"></i>
                        Usar materiais salvos
                    </button>

                </div>


                <div id="materiaisSelecionados"></div>


                <button type="submit" class="btn-cadastrar">
                    Cadastrar aula
                </button>

            </form>

        </div>

    </dialog>


    <dialog class="modal" id="modalMateriaisSalvos">

        <div class="modal-conteudo">

            <button type="button" class="fechar" id="fecharMateriaisSalvos">
                <i class="bx bx-x"></i>
            </button>


            <div id="pastasPlanejamento">

                <h2>Materiais salvos</h2>

                <div id="listaPastasPlanejamento"></div>

            </div>


            <div id="materiaisPasta" style="display: none;">

                <button type="button" id="voltarPastas">
                    <i class="bx bx-arrow-back"></i>
                    Voltar
                </button>

                <h2 id="nomePastaPlanejamento"></h2>

                <div id="listaMateriaisPasta"></div>

                <button type="button" id="adicionarMateriaisAula">
                    Adicionar à aula
                </button>

            </div>

        </div>

    </dialog>


    <dialog class="modal" id="modalMaterial">

        <div class="modal-conteudo">

            <button type="button" class="fechar" id="fecharMaterial">
                <i class="bx bx-x"></i>
            </button>

            <button type="button" id="voltarMaterial">
                <i class="bx bx-arrow-back"></i>
                Voltar
            </button>

            <div id="conteudoMaterial">

            </div>

        </div>

    </dialog>


<dialog class="modal" id="modalExcluirAula">

    <div class="modal-conteudo">

        <button type="button" class="fechar" id="fecharExcluirAula">
            <i class="bx bx-x"></i>
        </button>

        <h2>Excluir aula</h2>

        <p>Tem certeza que deseja excluir esta aula?</p>

        <div class="acoes-excluir">

            <button type="button" id="cancelarExcluirAula">
                Cancelar
            </button>

            <button type="button" id="confirmarExcluirAula">
                Excluir
            </button>

        </div>

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

                <a href="pesquisar.php">
                    <i class="bx bx-search-alt"></i>
                    <span class="tooltip">Pesquisar</span>
                </a>

            </li>


            <li class="active">

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

    <script src="../js/planejamento.js"></script>

    <script src="../js/pastasPlanejamento.js"></script>

</body>

</html>