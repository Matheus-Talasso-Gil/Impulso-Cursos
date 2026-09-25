<?php
require_once __DIR__ . '/../includes/session.php'; require_once __DIR__ . '/../database/connect_postgres.php'; ?>
<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastre-se</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php' ?>
    <main>
        <h1>Cadastre-se no Sistema</h1>
        <form action="" method="post">
            <br><label for="email">E-mail:</label>
            <input type="text" name="email" id="email" required><br><br>
            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha"><br><br>
            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
        </form>
       <?php 
       if($_SERVER['REQUEST_METHOD'] == "POST"){
       cadastrar_user($conexao, $_POST['email'], $_POST['senha']);
       header("Location: ../index.php ");
       exit();
        }
       ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php' ?>
</body>

</html>