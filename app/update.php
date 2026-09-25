<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../login/verificar_user.php';
require_once __DIR__ . '/../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <h1>Atualizar aluno</h1>
    <?php
    $aluno = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = 'SELECT * FROM alunos WHERE id = :id';
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($aluno && isset($_POST['nome'])) {
            Atualizar($conexao, $id, $_POST['nome'], $_POST['turma'], $_POST['nasc'], $_POST['ativo'], $_POST['email']);
            $stmt->execute();
            $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        if (!$aluno) {
            echo '<p>Aluno não encontrado.</p>';
        }
    } else {
        echo '<p>Digite o ID do aluno para carregar os dados ou escolha Editar no relatório.</p>';
    }
    ?>
    <?php if (!$aluno): ?>
    <form action="" method="post">
        <label for="id">ID do aluno:</label>
        <input type="number" name="id" id="id" min="1" max="255" required>
        <input type="submit" value="Buscar aluno">
    </form>
    <?php endif; ?>
    <?php if ($aluno): ?>
    <form action="" method="post">
        <p>ID: <?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?></p>
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') ?>" required>
        <br><br>
        <label for="turma">Turma:</label>
        <input type="text" name="turma" id="turma" value="<?= htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') ?>" required>
        <br><br>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars((string) ($aluno['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
        <br><br>
        <label for="nasc">Nascimento:</label>
        <input type="date" name="nasc" id="nasc" value="<?= htmlspecialchars((string) $aluno['nasc'], ENT_QUOTES, 'UTF-8') ?>" required>
        <br><br>
        <label>Ativo:</label>
        <input type="radio" name="ativo" id="ativo_sim" value="true" <?= $aluno['ativo'] ? 'checked' : '' ?> required>
        <label for="ativo_sim">SIM</label>
        <input type="radio" name="ativo" id="ativo_nao" value="false" <?= !$aluno['ativo'] ? 'checked' : '' ?>>
        <label for="ativo_nao">NÃO</label>
        <br><br>
        <input type="submit" value="Atualizar">
        <input type="reset" value="Restaurar campos">
    </form>
    <?php endif; ?>
    <p><a href="select.php">Consultar RL</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>