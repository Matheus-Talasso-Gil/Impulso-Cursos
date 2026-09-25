<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <h1>Excluir aluno</h1>
    <form action="" method="post">
        <label for="id">ID: </label>
        <input type="number" name="id" id="id" required>
        <input type="submit" value="Apagar">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        apagar($conexao);
    }
    ?>
    <p><a href="select.php">Consultar RL</a></p>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>