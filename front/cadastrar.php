<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
     <main class="pagina-cadastro">
        <aside class="painel-ilustracao" aria-label="Ambiente educacional"></aside>

        <section class="painel-cadastro">
            <div class="box-cadastro">
                <a class="logo" href="../index.php"><span>✦</span> Sirius</a>
                <form action="../php/cadUsuario.php" method="POST">
                    <h1>Crie uma conta</h1>
                    <p>Cadastre-se para acessar o banco de exercícios.</p>

                    <div id="mensagem" style="display: none; text-align: center; margin-bottom: 15px; color: #ff3333; font-weight: bold;"></div>

                    <div class="campo">
                        <label for="nome">Nome completo</label>
                        <input type="text" placeholder="Seu nome" id="nome" name="nome" required>
                    </div>
                    <div class="campo">
                        <label for="username">Nome de usuário</label>
                        <input type="text" placeholder="Seu usuário" id="username" name="username" required>
                    </div>
                    <div class="campo">
                        <label for="email">E-mail</label>
                        <input type="email" placeholder="voce@email.com" id="email" name="email" required>
                    </div>
                    <div class="campo">
                        <label for="senha">Senha</label>
                        <input type="password" placeholder="Crie uma senha" id="senha" name="senha" required>
                    </div>
                    <div class="campo">
                        <label for="confirmaSenha">Confirme sua senha</label>
                        <input type="password" placeholder="Repita a senha" id="confirmaSenha" name="confirmaSenha" required>
                    </div>

                    <div class="aceite">
                        <input type="checkbox" id="mostrar">
                        <label for="mostrar">Mostrar senha</label>
                    </div>
                    <button type="submit" class="botao-cadastrar" id="botaoCadastrar">Criar conta</button>
                </form>
                <p class="login-link">Já possui uma conta? <a href="logar.php">Entrar</a></p>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/cadUsu.js"></script>
</body>
</html>