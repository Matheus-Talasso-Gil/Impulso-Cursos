<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verificar_admin.php';
$_SESSION['exclusao_token'] ??= bin2hex(random_bytes(32));
if ($_SERVER['REQUEST_METHOD'] !== 'POST') unset($_SESSION['exclusao_pendente'], $_SESSION['exclusao_cursos']);
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
<main class="delete-page">
    <h1>Excluir aluno</h1>
    <?php
 $aluno = false;
$cursos = [];
$confirmacaoCursos = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) { // verifica se recebeu um id pelo formulario
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0;
    $sql = 'SELECT * FROM alunos WHERE id = :id'; // carrega o aluno antes de exibir a confirmação ou excluir
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id); // liga o id recebido ao parâmetro da consulta
    $stmt->execute(); // executa a busca pelo id recebido
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC); // pega os dados do aluno encontrado
    if (!$aluno) {
        echo '<p class="message-error" role="alert">Aluno não encontrado.</p>';
    } else {
        $stmt = $conexao->prepare('SELECT c.id, c.nome FROM inscricoes i JOIN cursos c ON c.id = i.curso_id WHERE i.usuario_id = :usuario_id ORDER BY c.id');
        $stmt->execute([':usuario_id' => $aluno['usuario_id']]);
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dados = ['id' => $id, 'usuario_id' => $aluno['usuario_id'], 'cursos' => array_column($cursos, 'id')];
        if (isset($_POST['confirmar']) || isset($_POST['confirmar_cursos'])) {
            if (!is_string($_POST['token'] ?? null) || !hash_equals($_SESSION['exclusao_token'], $_POST['token'])) {
                echo '<p class="message-error" role="alert">Solicitação inválida. Recarregue a página.</p>';
            } elseif (($_SESSION['exclusao_pendente'] ?? null) !== $dados) {
                echo '<p class="message-warning" role="alert">Confira os dados atualizados antes de confirmar.</p>';
            } elseif ($cursos && (!isset($_POST['confirmar_cursos']) || ($_SESSION['exclusao_cursos'] ?? null) !== $dados)) {
                $confirmacaoCursos = true;
                $_SESSION['exclusao_cursos'] = $dados;
            } else {
                try {
                    apagar($conexao, $id);
                    $aluno = false;
                    unset($_SESSION['exclusao_pendente'], $_SESSION['exclusao_cursos']);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    echo '<p class="message-error" role="alert">Não foi possível excluir. Confira se a migration atualizada foi executada.</p>';
                }
            }
        }
        if (!isset($_POST['confirmar']) && !isset($_POST['confirmar_cursos'])) unset($_SESSION['exclusao_cursos']);
        if ($aluno) $_SESSION['exclusao_pendente'] = $dados;
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
    <h2><?= $confirmacaoCursos ? 'Atenção: este aluno está inscrito em cursos' : 'Deseja excluir este aluno?' ?></h2>
    <p>ID: <?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?></p> <!-- mostra o id do aluno -->
    <p>Nome: <?= htmlspecialchars((string) $aluno['nome'], ENT_QUOTES, 'UTF-8') ?></p> <!-- mostra o nome do aluno -->
    <p>Turma: <?= htmlspecialchars((string) $aluno['turma'], ENT_QUOTES, 'UTF-8') ?></p> <!-- mostra a turma do aluno -->
    <?php if ($confirmacaoCursos): ?>
        <ul>
            <?php foreach ($cursos as $curso): ?>
                <li><?= htmlspecialchars((string) $curso['nome'], ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
        <p class="message-warning" role="alert">A exclusão é definitiva. A conta do usuário e suas inscrições nos cursos serão mantidas. O perfil deixará de ter um cadastro de aluno vinculado. Deseja continuar?</p>
    <?php elseif ($aluno['usuario_id'] !== null): ?>
        <p>A conta do usuário será mantida e perderá o vínculo com este cadastro de aluno.</p>
    <?php endif; ?>
    <form action="" method="post" class="danger-confirmation"> <!-- inicia o formulario de confirmacao -->
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $aluno['id'], ENT_QUOTES, 'UTF-8') ?>"> <!-- guarda o id escondido para enviar novamente -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['exclusao_token'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="submit" name="<?= $confirmacaoCursos ? 'confirmar_cursos' : 'confirmar' ?>" value="<?= $confirmacaoCursos ? 'Excluir aluno mesmo com cursos' : 'Confirmar exclusão' ?>">
        <a class="cancel-link" href="delete.php">Cancelar</a>
    </form>
    <?php endif; ?>
    <p><a class="report-link" href="select.php">Consultar RL</a></p>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
