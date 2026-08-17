<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
   <main class="pagina-cadastro">
        <aside class="painel-ilustracao" aria-label="Ambiente educacional"></aside>

        <section class="painel-cadastro">
            <div class="box-cadastro">
                <a class="logo" href="../index.php"><span>✦</span> Sirius</a>
                <form action="../php/verificar.php" method="POST">
                    <h1>Entre em sua conta</h1>
                    <p>Acesse seu banco de exercícios.</p>

                    <div id="mensagem" style="display:none; font-weight:bold; margin:10px 0;"></div>

                    <div class="campo">
                        <label for="username">Email ou nome de Usuário</label>
                        <input type="text" placeholder="Digite seu Email ou seu nome de Usuário" id="email" name="email" required>
                    </div>
                    <div class="campo">
                        <label for="senha">Senha</label>
                        <input type="password" placeholder="Digite sua senha" id="senha" name="senha" required>
                    </div>

                    <button type="submit" class="botao-cadastrar" id="botaoLogar">Entrar</button>
                </form>
                <p class="login-link">Não possui uma conta? <a href="cadastrar.php">Cadastre-se</a></p>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/loginUsu.js"></script>

</body>
</html>