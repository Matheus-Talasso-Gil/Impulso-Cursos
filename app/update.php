<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../login/verificar_admin.php';
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
$aluno = false; // comeca sem aluno carregado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['id']) || isset($_POST['nome']))) {
    $id = isset($_POST['nome']) ? (int) ($_SESSION['aluno_edicao_id'] ?? 0) : (int) ($_POST['id'] ?? 0); // usa o id original
    $stmt = $conexao->prepare('SELECT * FROM alunos WHERE id = :id'); // prepara a busca
    $stmt->execute([':id' => $id]); // executa a busca
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // guarda o aluno
    if ($aluno && !isset($_POST['nome'])) {
        $_SESSION['aluno_edicao_id'] = $aluno['id']; // guarda o id original
        $_SESSION['aluno_edicao_cpf'] = $aluno['cpf']; // guarda o cpf original
        $_SESSION['aluno_edicao_nasc'] = $aluno['nasc']; // guarda o nascimento original
    }
    if ($aluno && isset($_POST['nome'])) {
        $cpf = $_SESSION['aluno_edicao_cpf'] ?? ''; // recupera o cpf original
        $nasc = $_SESSION['aluno_edicao_nasc'] ?? ''; // recupera o nascimento original

        if ($cpf === '' || $nasc === '') {
            echo '<p class="message-error">Não foi possível recuperar os dados originais do aluno.</p>';
        } else {
            Atualizar($conexao, $id, $_POST['nome'], $_POST['turma'], $nasc, $_POST['ativo'], $_POST['email'], $cpf); // atualiza os campos permitidos
            $stmt->execute([':id' => $id]); // busca novamente o aluno
            $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // carrega os dados atualizados
        }
    }
    if (!$aluno) echo '<p class="message-error">Aluno não encontrado.</p>'; // informa quando nao encontra aluno
} else {
    echo '<p class="message-warning">Digite o ID do aluno para carregar os dados ou escolha Editar no relatório.</p>'; // orienta antes da busca
}
?>
<?php if (!$aluno): ?>
<form method="post">
    <label for="id">ID do aluno:</label>
    <input type="number" name="id" id="id" min="1" max="255" required>
    <input type="submit" value="Buscar aluno">
</form>
<?php endif; ?>
<?php if ($aluno): ?>
<form method="post">
    <!-- exibe o id sem permitir alteracao -->
    <p>ID: <?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?></p>
    <!-- permite alterar o nome -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') ?>" required>
    <!-- exibe o cpf sem permitir alteracao -->
    <label>CPF:</label>
    <p><?= htmlspecialchars((string) $aluno['cpf'], ENT_QUOTES, 'UTF-8') ?></p>
    <!-- permite alterar a turma -->
    <label for="turma">Turma:</label>
    <input type="text" name="turma" id="turma" value="<?= htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') ?>" required>
    <!-- permite alterar o email -->
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars((string) $aluno['email'], ENT_QUOTES, 'UTF-8') ?>" required>
    <!-- exibe o nascimento sem permitir alteracao -->
    <label>Data de nascimento:</label>
    <p><?= htmlspecialchars((string) $aluno['nasc'], ENT_QUOTES, 'UTF-8') ?></p>
    <!-- permite alterar a situacao -->
    <label>Ativo:</label>
    <input type="radio" name="ativo" id="ativo_sim" value="true" <?= $aluno['ativo'] ? 'checked' : '' ?> required>
    <label for="ativo_sim">SIM</label>
    <input type="radio" name="ativo" id="ativo_nao" value="false" <?= !$aluno['ativo'] ? 'checked' : '' ?>>
    <label for="ativo_nao">NÃO</label>
    <input type="submit" value="Atualizar">
    <input type="reset" value="Restaurar campos">
</form>
<?php endif; ?>
<p><a class="report-link" href="select.php">Consultar RL</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>