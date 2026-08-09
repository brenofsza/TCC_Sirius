<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
   

        <form action="../php/cadUsuario.php" method="POST">
            <h1>Crie uma conta</h1>

            <div id="mensagem" style="display: none; text-align: center; margin-bottom: 15px; color: #ff3333; font-weight: bold;"></div>
           
            <div class="">
                <input type="text" placeholder="Nome" id="nome" name="nome"
                required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="">
                <input type="email" placeholder="Email" id="email" name="email"
                required>
                <i class='bx bx-envelope'></i>
            </div>

            <div class="">
                <input type="password" placeholder="Senha" id="senha" name="senha"
                required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="">
                <input type="password" placeholder="Confirme sua senha" id="confirmaSenha" name="confirmaSenha"
                required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            

            <div class="remember-forgot">
                <label><input type="checkbox"> Lembrar</label>
            </div>

            <div class="btn-container">
                
                <button type="submit" class="" id="botaoCadastrar">Criar</button>
            </div>
        </form>
        <a href="../index.php"><button>Voltar</button></a>
        Já possui uma conta? <a href="logar.php">Entrar</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/cadUsu.js"></script>

</body>
</html>