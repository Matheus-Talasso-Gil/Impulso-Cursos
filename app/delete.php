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
    <title>Deletar Usuário</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- puxa o arquivo css que estiliza a pagina -->
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <h1>Excluir aluno</h1>
    <?php
 $aluno = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) { // verifica se recebeu um id pelo formulario
    $id = $_POST['id'];
    $sql = 'SELECT * FROM alunos WHERE id = :id';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id); // liga o id recebido ao parametro da consulta
    $stmt->execute();
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // pega os dados do aluno encontrado
    if (!$aluno) {
        echo '<p>Aluno não encontrado.</p>';
    } else {
        if (isset($_POST['confirmar'])) { // so exclui quando o usuario confirma
            apagar($conexao);
            $aluno = false;
        }
        }
    }
    ?>
    <?php if (!$aluno): ?> <!-- se nao tiver aluno carregado mostra o formulario de id -->
    <form action="" method="post">
        <label for="id">ID do aluno:</label>
        <input type="number" name="id" id="id" min="1" max="255" required>
        <input type="submit" value="Continuar para exclusão">
    </form>
    <?php else: ?> <!-- se o aluno for encontrado mostra os dados e a confirmacao -->
    <h2>Deseja excluir este aluno?</h2>
    <p>ID: <?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?></p> <!-- mostra o id do aluno -->
    <p>Nome: <?= htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') ?></p> <!-- mostra o nome do aluno -->
    <p>Turma: <?= htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') ?></p> <!-- mostra a turma do aluno -->

    <form action="" method="post"> <!-- inicia o formulario de confirmacao -->
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?>"> <!-- guarda o id escondido para enviar novamente -->
        <input type="submit" name="confirmar" value="Confirmar exclusão"> <!-- envia a confirmacao para permitir a exclusao -->
        <a href="delete.php">Cancelar</a>
    </form>
    <?php endif; ?>
    <p><a href="select.php">Consultar RL</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>