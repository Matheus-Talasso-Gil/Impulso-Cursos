<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../login/verificar_user.php';
require_once __DIR__ . '/../database/connect_postgres.php';
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
    <main>
    <h1>Cursos disponíveis</h1>
    <p>Escolha um curso para começar seus estudos</p>
    <?php
    $stmt = $conexao->prepare('SELECT * FROM cursos ORDER BY id');// busca todos os cursos cadastrados
    $stmt->execute(); // executa a consulta
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC); // guarda os cursos encontrados
    ?>
    <?php if (!$cursos): ?>
        <p class="message-warning">Nenhum curso cadastrado</p>
    <?php else: ?>
        <section class="courses"><!-- organiza os cursos em cards -->
            <div class="course-grid">
                <?php foreach ($cursos as $curso): ?>
                    <article class="course-card"><!-- exibe os dados do curso -->
                        <h3><?= htmlspecialchars($curso['nome'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><?= htmlspecialchars($curso['descricao'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="course-duration">
                            <?= htmlspecialchars((string) $curso['carga_horaria'], ENT_QUOTES, 'UTF-8') ?> horas
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>