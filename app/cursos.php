<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../login/verificar_user.php';
require_once __DIR__ . '/../database/connect_postgres.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso_id'])) {
    $usuario_id = (int) $_SESSION['id']; // pega o id do usuario logado
    $curso_id = (int) $_POST['curso_id']; // pega o curso escolhido
    $stmt = $conexao->prepare('SELECT id FROM inscricoes WHERE usuario_id = :usuario_id AND curso_id = :curso_id');// verifica se a inscricao ja existe
    $stmt->execute(['usuario_id' => $usuario_id, 'curso_id' => $curso_id]);
    if ($stmt->fetch()) {
        $mensagem = 'Você já está inscrito neste curso.';
    } else {
        $stmt = $conexao->prepare('INSERT INTO inscricoes (usuario_id, curso_id) VALUES (:usuario_id, :curso_id) ON CONFLICT (usuario_id, curso_id) DO NOTHING'); // salva a inscricao do usuario
        $stmt->execute(['usuario_id' => $usuario_id, 'curso_id' => $curso_id]);
        $mensagem = $stmt->rowCount() ? 'Inscrição realizada com sucesso.' : 'Você já está inscrito neste curso.';
    }
}
$stmt = $conexao->query('SELECT * FROM cursos ORDER BY id');// busca todos os cursos cadastrados
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos | Impulso Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <h1>Cursos disponíveis</h1>
    <p>Escolha um curso para começar seus estudos</p>
    <?php if (isset($mensagem)): ?>
        <p class="message-success"><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <?php if (!$cursos): ?>
        <p class="message-warning">Nenhum curso cadastrado</p>
    <?php else: ?>
        <section class="courses">
            <div class="course-grid">
                <?php foreach ($cursos as $curso): ?>
                    <article class="course-card">
                        <h3><?= htmlspecialchars($curso['nome'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><?= htmlspecialchars($curso['descricao'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="course-duration"><?= (int) $curso['carga_horaria'] ?> horas</p>
                        <form method="post"><!-- envia o curso escolhido para inscricao -->
                            <input type="hidden" name="curso_id" value="<?= (int) $curso['id'] ?>">
                            <input type="submit" value="Inscrever-se">
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
