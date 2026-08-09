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
   

        <form action="../php/verificar.php" method="POST">
            <h1>Entre em sua conta</h1>

            <div id="mensagem" style="display: none; text-align: center; margin-bottom: 15px; color: #ff3333; font-weight: bold;"></div>
           
            

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
                
                <button type="submit" class="" id="botaoLogar">Entrar</button>
            </div>
        </form>
        <a href="../index.php"><button>Voltar</button></a>
        Não possui uma conta? <a href="cadastrar.php">Cadastre-se</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/loginUsu.js"></script>

</body>
</html>