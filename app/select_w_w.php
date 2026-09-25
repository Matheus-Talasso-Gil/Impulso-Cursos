<?php
require_once __DIR__ . '/../includes/session.php'; 
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';
?>
<?php require_once __DIR__ . '/../includes/functions.php';
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar aluno</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

        <?php include __DIR__ . '/../includes/header.php' 
        ?>
        <main>
        <h1>Consultar aluno</h1>
        <section class="forms">
            <form action="" method="post">
                <label for="id">ID do aluno: </label>
                <input type="number" name="id" id="id" required>
                <input type="submit" value="Consultar">
            </form>
        </section>
        <p><a href="select.php">Consultas RL</a></p>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            if ($id < 2147483647) {
                read_w_w($conexao, $id);
            } 
            else {
                echo "Número inválido, tente novamente <br>";
            }
        }
        echo '</main>';
        include __DIR__ . '/../includes/footer.php'; 
        ?>

</body>
</html>