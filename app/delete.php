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
    <title>Deletar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <h1>Excluir aluno</h1>
    <?php
    $aluno = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        // Busca o aluno antes de pedir a confirmação ou excluir.
        $sql = 'SELECT * FROM alunos WHERE id = :id';
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$aluno) {
            echo '<p>Aluno não encontrado.</p>';
        } else {
            // A busca envia só o ID. Este botão também envia "confirmar".
            if (isset($_POST['confirmar'])) {
                apagar($conexao);
                $aluno = false;
            }
        }
    }
    ?>
    <?php if (!$aluno): ?>
    <form action="" method="post">
        <label for="id">ID do aluno:</label>
        <input type="number" name="id" id="id" min="1" max="2147483647" required>
        <input type="submit" value="Continuar para exclusão">
    </form>
    <?php else: ?>
    <h2>Deseja excluir este aluno?</h2>
    <p>ID: <?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Nome: <?= htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Turma: <?= htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') ?></p>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="submit" name="confirmar" value="Confirmar exclusão">
        <a href="delete.php">Cancelar</a>
    </form>
    <?php endif; ?>
    <p><a href="select.php">Consultar RL</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>