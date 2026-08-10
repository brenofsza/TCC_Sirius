<?php session_start(); ?>
<?php
include "../php/conexao.php";

$id = $_SESSION['id_usuario'];
$result = mysqli_query($conexao, "SELECT * FROM USUARIO
  WHERE ID_USU=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <img src="" alt="">
    <?php echo $_SESSION['nome'];
          echo "<br>";
          echo $_SESSION['username']; ?>

    <button id="editPerfil">Editar Perfil</button>

    <dialog id="ModalPerfil">
        <h2>Editar Perfil</h2>

        <input type="hidden" name="id"
        value="<?php echo $row['ID_USU'];?>"><br>

        <div class="">
            Nome: <input type="text" name="nome" id="nome"
            value="<?php echo $row['NOME_USU'];?>" required><br>
                <i class='bx bxs-user'></i>
            </div>

            <div class="">
                Username: <input type="text" name="username" id="username"
                value="<?php echo $row['USERNAME'];?>" required><br>
                <i class='bx bxs-user'></i>
            </div>

            <div class="">
                Email: <input type="text" name="email" id="email"
                value="<?php echo $row['EMAIL_USU'];?>" required><br>
                <i class='bx bx-envelope'></i>
                
            </div>

                
<br>
        <button id="editInfo">Editar</button>
        <button id="fechaEditPer">Fechar</button>
        
    </dialog>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/editUsu.js"></script>
</body>

</html>
