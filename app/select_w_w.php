<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- permite usar caracteres especiais e acentos na pagina -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- faz a pagina se adaptar melhor em celular -->
    <title>Consultar aluno</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- puxa o arquivo css que estiliza a pagina -->
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Consultar aluno</h1>
        <section class="forms">
            <form action="" method="post"> <!-- envia o id digitado para a mesma pagina -->
                <label for="id">ID do aluno: </label>
                <input type="number" name="id" id="id" required>
                <input type="submit" value="Consultar">
            </form>
        </section>
        <p><a href="select.php">Consultas RL</a></p>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) { // verifica se o formulario foi enviado e se recebeu um id
            $id = $_POST['id'];
            if ($id < 255) { // verifica se o id esta dentro do limite aceito
                read_w_w($conexao, $id); // chama a funcao que busca e mostra o aluno pelo id
            }
            else {
                echo "Número inválido, tente novamente <br>";
            }
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>